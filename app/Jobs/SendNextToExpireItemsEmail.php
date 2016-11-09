<?php

namespace App\Jobs;

use App\Commons\Globals;
use App\Commons\UserContract;
use App\Entities\User;
use App\Mail\NextToExpire;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNextToExpireItemsEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	protected $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where(UserContract::EMAIL_EACH, '<>', null)->get();
	    foreach ($users as $user) {
		    $nextEmail = $user->lastCarbonEmail->addDays($user->email_each_days)->setTime(7, 0, 0);
		    $now = Carbon::now()->setTime(7, 0, 0);

		    if ($now->gt($nextEmail)) {
		        $nextToExpireArticles = $this->nextToExpireArticles($user);

			    if (sizeof($nextToExpireArticles) > 0) {

				    // Enviamos email y almacenamos dicha info en el usuario
				    Mail::to($user->email, $user->completeName)->send(new NextToExpire($nextToExpireArticles));

				    // Actualizamos el día de envío del email
				    $user->last_email = $now->format( Globals::CARBON_SQL_FORMAT . ' H:i:s' );
				    $user->save();
			    }
		    }
	    }
    }

    private function nextToExpireArticles(User $user)
    {
	    $res = [];
	    $nextToExpireArticles = $this->articleRepository->getNextToExpireToUserEmail($user);

	    foreach ($nextToExpireArticles as $article) {
		    $article->expiration = Carbon::createFromFormat( Globals::CARBON_SQL_FORMAT, $article->expiration)->format(Globals::CARBON_VIEW_FORMAT);
		    $res[$article->centerName][]=$article;
	    }
	    return $res;
    }
}
