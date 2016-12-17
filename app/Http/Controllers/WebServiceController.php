<?php

namespace App\Http\Controllers;

use App\Commons\AlfagesMovementsContract;
use App\Commons\ArticleContract;
use App\Commons\ArticleGroupContract;
use App\Commons\ArticleNewContract;
use App\Commons\ArticleSubGroupContract;
use App\Commons\Globals;
use App\Commons\PalletArticleContract;
use App\Commons\StoreContract;
use App\Entities\AlfagesMovement;
use App\Entities\Article;
use App\Entities\ArticleGroup;
use App\Entities\ArticleNew;
use App\Entities\ArticleSubGroup;
use App\Entities\PalletArticle;
use App\Entities\Store;
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

	private function getMovements(Array $item)
	{
		return AlfagesMovement::where(AlfagesMovementsContract::STORE, $item['ALMACEN'])
			->where(AlfagesMovementsContract::DATE, Carbon::createFromFormat( Globals::CARBON_VIEW_FORMAT, $item['FECHA'])->format(Globals::CARBON_SQL_FORMAT))
			->where(AlfagesMovementsContract::TYPE, $item['TIPODOC'])
			->where(AlfagesMovementsContract::DOCUMENT, $item['DOC'])
			->where(AlfagesMovementsContract::ARTICLE, $item['ART'])
			->where(AlfagesMovementsContract::QUANTITY, $item['CANTIDAD'])
			->where(AlfagesMovementsContract::LOT, $item['LOTE'])->first();
	}

	private function addMovement (Array $item)
	{
		AlfagesMovement::create( [
			AlfagesMovementsContract::STORE    => $item['ALMACEN'],
			AlfagesMovementsContract::DATE     => Carbon::createFromFormat( Globals::CARBON_VIEW_FORMAT, $item['FECHA'])->format(Globals::CARBON_SQL_FORMAT),
			AlfagesMovementsContract::TYPE     => $item['TIPODOC'],
			AlfagesMovementsContract::DOCUMENT => $item['DOC'],
			AlfagesMovementsContract::ARTICLE  => $item['ART'],
			AlfagesMovementsContract::QUANTITY => $item['CANTIDAD'],
			AlfagesMovementsContract::LOT      => $item['LOTE']
		] );
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
		ini_set('max_execution_time', 500);

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
		$deleted = [];
		$updated = [];
		$failed  = [];
		$abonos  = [];

		foreach ($request->all() as $item) {

			if (($item['TIPODOC'] != 'Alb Com' && $item['TIPODOC'] && 'Fra Com' && $item['TIPODOC'] != 'Alb Vta') || $item['CANTIDAD'] == 0) {
				continue;
			}

			// Comprobamos si el movimiento ya ha sido tratado
			if (!empty($this->getMovements($item))) {
				continue;
			}

			$selectedStore = Store::where(StoreContract::NAME, $item['ALMACEN'])->first();
			$selectedArticle = Article::where(ArticleContract::CODE, $item['ART'])->first();

			if (empty($selectedStore) || empty($selectedArticle)) {
				continue;
			}

			$insertedArticle = ArticleNew::where(ArticleNewContract::ARTICLE_ID, $selectedArticle->id)
				->where(ArticleNewContract::STORE_ID, $selectedStore->id)
				->where(ArticleNewContract::DOC, $item['DOC'])->first();

			if ($item['TIPODOC'] == 'Alb Com' || $item['TIPODOC'] == 'Fra Com') {

				if ($item['CANTIDAD'] < 0) {

					// Es posible que ya hayamos insertado la compra positiva, la buscamos.
					if (!empty($insertedArticle)) {

						$insertedArticle->total = $insertedArticle->total + $item['CANTIDAD'];

						if ($insertedArticle->total == 0) {
							$insertedArticle->forceDelete();
						} else {
							$insertedArticle->save();
						}

					} else {
						$abonos[$item['DOC']][$item['ART']] = $item;
					}
					$this->addMovement($item);
					continue;
				} else {
					if (!empty($insertedArticle)) {
						$this->addMovement($item);
						continue;
					}
				}

				try {

					if (isset($abonos[$item['DOC']][$item['ART']])) {
						$itemAbono = $abonos[$item['DOC']][$item['ART']];
						$item['CANTIDAD'] = $item['CANTIDAD'] + $itemAbono['CANTIDAD'];
					}

					$newArticle = ArticleNew::create( [
						ArticleNewContract::ARTICLE_ID => $selectedArticle->id,
						ArticleNewContract::STORE_ID   => $selectedStore->id,
						ArticleNewContract::DOC        => $item['DOC'],
						ArticleNewContract::LOT        => $item['LOTE'],
						ArticleNewContract::TOTAL      => $item['CANTIDAD'],
						ArticleNewContract::DATE       => Carbon::createFromFormat( Globals::CARBON_VIEW_FORMAT, $item['FECHA'])->format(Globals::CARBON_SQL_FORMAT),
						ArticleNewContract::EXPIRATION => $item['CADUCIDAD'] != null ?
							Carbon::createFromFormat( Globals::CARBON_VIEW_FORMAT, $item['CADUCIDAD'])->format(Globals::CARBON_SQL_FORMAT) : null,
					] );

					$created[] = $newArticle;
				} catch ( \PDOException $exception ) {
					$failed[] = [ "{$item['ART']}-{$item['LOTE']}", 'This item exists in the database' ];
				} catch ( Exception $e ) {
					Log::info( "[WebService] Error creating newArticle: {$e->getMessage()}" );
					$failed[] = [ "{$item['ART']}-{$item['LOTE']}", $e ];
				}

				try {
					$this->addMovement($item);
				} catch ( Exception $e ) {
					Log::info( "[WebService] Error creating AlfagesMovement: Posible duplicado" );
				}
			} else if ($item['TIPODOC'] == 'Alb Vta') {

				if (!empty($insertedArticle)) {
					// Esto significa que tenemos el artículo en la tabla de nuevos artículos
					$insertedArticle->total = $insertedArticle->total + $item['CANTIDAD'];

					if ($insertedArticle->total == 0) {
						$insertedArticle->forceDelete();
					} else {
						$insertedArticle->save();
					}
					$this->addMovement($item);
				}

				$pickingStore = Store::where(StoreContract::CENTER_ID, $selectedStore->center_id)
					->where(StoreContract::NAME, 'Picking')
					->with('pallets.articles')->firstOrFail();

				if ($item['CANTIDAD'] > 0) {
					//TODO: ¿Qué hacemos con esto? Posiblemente tratarlo como un articleNew
					continue;
				}

				foreach ($pickingStore->pallets as $pallet) {
					foreach ($pallet->articles as $article) {
						if ($article->id == $selectedArticle->id && $article->pivot->lot == $item['LOTE']) {
							$palletArticleId = $article->pivot->id;

							if ($item['CANTIDAD']*(-1) == $article->pivot->number) {
								// Eliminamos la entrada en pallet_articles
								PalletArticle::destroy($palletArticleId);
								$deleted[] = $palletArticleId;
							} else {
								// Actualizamos la entrada en pallet_articles
								$palletArticle = PalletArticle::where(PalletArticleContract::ID, $palletArticleId)->firstOrFail();
								$palletArticle->number = $article->pivot->number + $item['CANTIDAD'];
								$palletArticle->update();
								$updated[] = $palletArticle;
							}
							$this->addMovement($item);
						}
					}
				}

			}
		}

		return Response::json( [ 'created' => $created, 'failed' => $failed, 'updated' => $updated, 'deleted' => $deleted], 200 );
	}

}
