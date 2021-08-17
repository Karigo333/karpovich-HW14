<?php

namespace App\Http\Controllers;


use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login()
    {

        $gitHubUrl = 'https://github.com/login/oauth/authorize';

        $params = [
            'client_id' => env('OAUTH_GITHUB_CLIENT_ID'),
            'redirect_uri' => env('OAUTH_GITHUB_CALLBACK_URI'),
            'scope' => 'user,gist,user:email',
        ];

        $gitHubUrl .= '?' . http_build_query($params);
        return view('login', [
            'gitHubUrl' => $gitHubUrl
        ]);
    }

    public function callback(Request $request)
    {

        $params = [
            'client_id' => env('OAUTH_GITHUB_CLIENT_ID'),
            'redirect_secret' => env('OAUTH_GITHUB_CLIENT_SECRET'),
            'code' => $request->get('code'),
            'redirect_uri' => env('OAUTH_GITHUB_CALLBACK_URI')
        ];
        $tokenData = Http::withHeaders([
            'Accept' => 'application/json'
        ])
            ->post('https://github.com/login/oauth/access_token',
            $params)->json();

        $userData = Http::withHeaders([
            'Authorization' => 'token' . $tokenData['access_token']
        ])
            ->get('https://api.github.com/user')->json();

        if (!$userData) {
            throw new Exception('Cant fetch user');
        }

        $emailsData = Http::withHeaders([
            'Authorization' => 'token' . $tokenData['access_token']
        ])
            ->get('https://api.github.com/user')->json();

        if (isset($emailsData[0]['email'])) {
            throw new Exception('Cant fetch emails');
        }

        $email = $emailsData[0]['email'];

        $user = new User();
        $user->name = $userData['name'];
        $user->email = $email;
        $user->email_verified_at = now();
        $user->password = Hash::make(Str::random(100));
        $user->remember_token = Str::random(10);
        $user->save();
//**************************************************************
//        $userInfo = new UserInfo();
//        $userInfo->user_id => $user=>id;
//        $userInfo->user_id => $user=>id;
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->get('remember') === 'on';
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
