<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('hello',
    'HomeController@sayHello'
);

//protected group
Route::group(array('before' => 'auth.basic.once'), function() {
    Route::controller('api',
        'ApiController'
    );
});

Route::get('/oauth/login', function()
{
    return View::make('simplelogin');
});

Route::get('/oauth/logged', array('before' => 'oauth|oauth-owner:client', function(){
    return "oauth secured route for clients only id: ".ResourceServer::getOwnerId();
}));

//ROUTE FOR GETTING THE ACCESS TOKEN

Route::post('oauth/access_token', function()
{
    return AuthorizationServer::performAccessTokenFlow();
});

/*
 * EXAMPLE OF FILTERED ROUTE
 *
   Route::get('user/account', array('before' => 'auth',
        'uses' => 'UserController@account',
        'as' => 'user.account'
    ));
 */
