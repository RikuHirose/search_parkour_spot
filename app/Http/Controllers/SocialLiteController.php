<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\SocialProvider;
use App\User;


class SocialLiteController extends Controller
{

	use AuthenticatesUsers;

	protected $redirectTo = '/';

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

    public function login()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try
        {
          $socialUser = Socialite::driver('facebook')->user();

        }
        catch(Exception $e)
        {
          return redirect('/')->with(['success'=> 'Loginしました！']);
        }

        //すでに登録済みかチェック
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();

        if($socialProvider){
          $user = $socialProvider->user;
          auth()->login($user);

          return redirect('/')->with(['success'=> ' Loginしました！']);
        }

        //すでにemailがあるかチェック
        $socialProvider = User::where('email',$socialUser->getEmail())->first();


        if(!$socialProvider) {
            $user = User::Create(['email' => $socialUser->getEmail(), 'name' => $socialUser->getName(), 'avatar_name' => $socialUser->getAvatar(), 'remember_token' => $socialUser->token]);
        }
        else {
            // users tableからemail検索する
             $user = User::where('email', $socialUser->getEmail())->first();

        }

        //ソーシャルプロバイダーのテーブルにレコードを追加
        $user->socialProviders()->create(['provider_id' => $socialUser->getId(), 'provider' => 'facebook']);

        auth()->login($user);
        return redirect('/')->with(['success'=> 'Loginしました！']);



    }
}