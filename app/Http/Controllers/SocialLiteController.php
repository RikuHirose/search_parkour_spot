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
        dd(11);
        \Log::debug('a');
        try
        {
          $socialUser = Socialite::driver('facebook')->user();
          \Log::debug('b');

        }
        catch(Exception $e)
        {
            \Log::debug('c');
          return redirect('/')->with(['success'=> 'Loginしました！']);
        }

        //すでに登録済みかチェック
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
        \Log::debug('d');

        if($socialProvider){
            \Log::debug('e');
          $user = $socialProvider->user;
          auth()->login($user);

          return redirect('/')->with(['success'=> ' Loginしました！']);
        }

        //すでにemailがあるかチェック
        $socialProvider = User::where('email',$socialUser->getEmail())->first();
        \Log::debug('f');


        if(!$socialProvider) {
            \Log::debug('g');
            $user = User::Create(['email' => $socialUser->getEmail(), 'name' => $socialUser->getName(), 'avatar_name' => $socialUser->getAvatar(), 'remember_token' => $socialUser->token]);
        }
        else {
            // users tableからemail検索する
             $user = User::where('email', $socialUser->getEmail())->first();

        }
        \Log::debug('h');
        //ソーシャルプロバイダーのテーブルにレコードを追加
        $user->socialProviders()->create(['provider_id' => $socialUser->getId(), 'provider' => 'facebook']);

        auth()->login($user);
        \Log::debug('i');
        return redirect('/')->with(['success'=> 'Loginしました！']);



    }
}