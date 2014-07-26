<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

    public function sayHello(){
        $username = "pablo";
        $password = "aaa";

        $credentials = array(
            'username' => $username,
            'password' => $password,
        );
        if (Auth::check())
        {
            return "HELLO OAUTH REMEMBERED!<br>
                    you are ".Auth::user()->username;
        }
        if (Auth::attempt($credentials, true))
        {
            return "HELLO OAUTH!";
        }
        else return "HELLO FOREIGNER!";
    }

}

