<?php

namespace App\Http\Controllers;

use App\Commons\ArticleContract;
use App\Commons\ArticleGroupContract;
use App\Commons\ArticleNewContract;
use App\Commons\ArticleSubGroupContract;
use App\Commons\Globals;
use App\Entities\Article;
use App\Entities\ArticleGroup;
use App\Entities\ArticleNew;
use App\Entities\ArticleSubGroup;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class WebServiceController extends Controller
{

	private function validation(Array $rules, Request $request)
	{
		if (!is_array($request->all())) {
			return ['error' => 'Request must be an array'];
		}

		foreach ($request->all() as $item) {
			// Ejecutamos el validador y en caso de que falle devolvemos la respuesta
			// con los errores
			$validator = Validator::make( $item, $rules );
			if ( $validator->fails() ) {
				dd($validator->errors()->all());
				return Response::json([
					'created' => false,
					'errors'  => "The data is not correct. {$validator->errors()->all()}"
				], 500);
			}
		}

		return null;
	}

	public function groups(Request $request)
	{

		$rules = [
			'GRGRU'     => 'required',
			'GRDESSGR'  => 'required',
			'GRDEASGR'  => 'required'
		];

		if (($response = $this->validation($rules, $request)) != null) {
			return $response;
		}

		$created = [];
		$failed  = [];

		foreach ($request->all() as $item) {

			try {
				$articleGroup = ArticleGroup::create( [
					ArticleGroupContract::CODE => $item['GRGRU'],
					ArticleGroupContract::NAME => ucwords(strtolower($item['GRDEASGR']))
				] );

				$created[] = $articleGroup->code;
			} catch ( \PDOException $exception) {
				$failed[] = [$item['GRGRU'], 'This item exists in the database'];
			} catch ( Exception $e ) {
				Log::info( "[WebService] Error creating group: {$e->getMessage()}" );
				$failed[] = [$item['GRGRU'], $e->getMessage()];
			}
		}

		return Response::json( [ 'created' => $created, 'failed' => $failed], 200 );
	}

	public function subGroups(Request $request)
	{

		$rules = [
			'SGRGRU'    => 'required',
			'SGRSGR'    => 'required',
			'SGRDES'    => 'required',
			'SGRDEASGR' => 'required',
		];

		if (($response = $this->validation($rules, $request)) != null) {
			return $response;
		}

		$created = [];
		$failed  = [];
		$groups = ArticleGroup::all();

		foreach ($request->all() as $item) {

			$selectedGroup = null;
			foreach ($groups as $group) {
				if ($group->code == $item['SGRGRU']) {
					$selectedGroup = $group;
					break;
				}
			}

			if ($selectedGroup === null) {
				Log::info( "[WebService] Error creating subgroup: It doesn't exist a group with code {$item['SGRGRU']}" );
				$failed[] = ["{$item['SGRGRU']}-{$item['SGRSGR']}", 'The parent item does not exist in the database'];
				continue;
			}

			try {

				$articleSubGroup = ArticleSubGroup::create( [
					ArticleSubGroupContract::GROUP_ID => $selectedGroup->id,
					ArticleSubGroupContract::CODE     => $item['SGRSGR'],
					ArticleSubGroupContract::NAME     => ucwords(strtolower($item['SGRDEASGR'])),
				] );

				$created[] = "{$selectedGroup->code}-{$articleSubGroup->code}";
			} catch ( \PDOException $exception) {
				$failed[] = ["{$item['SGRGRU']}-{$item['SGRSGR']}", 'This item exists in the database'];
			} catch ( Exception $e ) {
				Log::info( "[WebService] Error creating subgroup: {$e->getMessage()}" );
				$failed[] = ["{$item['SGRGRU']}-{$item['SGRSGR']}", $e->getMessage()];
			}
		}

		return Response::json( [ 'created' => $created, 'failed' => $failed], 200 );
	}

	public function articles(Request $request)
	{

		$rules = [
			'ARCodArt'  => 'required',
			'ARDesL'    => 'required',
			'ARGrupo'   => 'required',
			'ARSGrupo'  => 'required',
			'ARActivo'  => 'required',
			'ARUniMedV' => 'required',
		];

		if (($response = $this->validation($rules, $request)) != null) {
			return $response;
		}

		$created = [];
		$failed  = [];

		$groupsAndSubgroups = ArticleGroup::with('subgroups')->get();

		foreach ($request->all() as $item) {

			$selectedSubgroup = null;

			foreach ($groupsAndSubgroups as $group) {
				if ($group->code == $item['ARGrupo']) {
					foreach ($group->subgroups as $subgroup) {
						if ($subgroup->code == $item['ARSGrupo']) {
							$selectedSubgroup = $subgroup;
							break;
						}
					}
					break;
				}
			}

			if ($selectedSubgroup === null) {
				Log::info( "[WebService] Error creating article: It doesn't exist a group and subgroup with code {$item['ARGrupo']}-{$item['ARSGrupo']}" );
				$failed[] = ["{$item['ARGrupo']}-{$item['ARSGrupo']}", 'The parent item does not exist in the database'];
				continue;
			}

			try {
				$article = Article::create( [
					ArticleContract::CODE        => $item['ARCodArt'],
					ArticleContract::NAME        => ucwords(strtolower($item['ARDesL'])),
					ArticleContract::SUBGROUP_ID => $selectedSubgroup->id,
					ArticleContract::UNITS       => $item['ARUniMedV'],
				] );

				$created[] = $article->name;
			} catch ( \PDOException $exception) {
				$failed[] = [$item['ARCodArt'], 'This item exists in the database'];
			} catch ( Exception $e ) {
				Log::info( "[WebService] Error creating article: {$e->getMessage()}" );
				$failed[] = [$item['ARCodArt'], $e->getMessage()];
			}
		}

		return Response::json( [ 'created' => $created, 'failed' => $failed], 200 );
	}

	public function movements(Request $request)
	{
		ini_set('max_execution_time', 60);

		$rules = [
			'ALMACEN'     => 'required',
			'FECHA'       => 'required',
			'TIPODOC'     => 'required',
			'DOC'         => 'required',
			'ART'         => 'required',
			'DESCRIPCION' => 'required',
			'UNIDAD'      => 'required',
			'CANTIDAD'    => 'required',
		];

		// Esta comentado porque tarda muchísimo en validar
		/*if (($response = $this->validation($rules, $request)) != null) {
			return $response;
		}*/

		$created = [];
		$failed  = [];

		foreach ($request->all() as $item) {

			if ($item['TIPODOC'] == 'Alb Com') {

				if ($item['LOTE'] == '') {
					continue;
				}

				try {
					$selectedArticle = Article::where(ArticleContract::CODE, $item['ART'])->firstOrFail();

					$newArticle = ArticleNew::create( [
						ArticleNewContract::ARTICLE_ID => $selectedArticle->id,
						ArticleNewContract::LOT        => $item['LOTE'],
						ArticleNewContract::TOTAL      => $item['CANTIDAD'],
						ArticleNewContract::EXPIRATION => $item['CADUCIDAD'] != null ?
							Carbon::createFromFormat( Globals::CARBON_VIEW_FORMAT, $item['CADUCIDAD'])->format(Globals::CARBON_SQL_FORMAT) : null,
					] );

					$created[] = $newArticle;
				} catch ( \PDOException $exception ) {
					$failed[] = [ "{$item['ART']}-{$item['LOTE']}", 'This item exists in the database' ];
				} catch ( Exception $e ) {
					Log::info( "[WebService] Error creating newArticle: {$e->getMessage()}" );
					$failed[] = [ "{$item['ART']}-{$item['LOTE']}", $e->getMessage() ];
				}
			}
		}

		return Response::json( [ 'created' => $created, 'failed' => $failed], 200 );
	}

}
