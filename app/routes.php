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
Route::group(array('before' => 'auth.basic'), function() {
    $route = "resources";
    Route::get($route, 'ResourceController@getIndex');
    Route::post($route, 'ResourceController@postIndex');
    Route::get($route.'/badges', 'ResourceController@getBadges');
    Route::get($route.'/badges/{badgeId}', 'ResourceController@getBadge');
    Route::get($route.'/badges/{badgeId}/owners', 'ResourceController@getBadgeOwners');
    Route::get($route.'/users', 'ResourceController@getUsers');
    Route::get($route.'/users/{userId}', 'ResourceController@getUser');
    Route::get($route.'/users/{userId}/badges', 'ResourceController@getUserBadges');
    Route::get($route.'/users/{userId}/badges/{badgeId}', 'ResourceController@getUserBadge');
    Route::put($route.'/users/{userId}/badges/{badgeId}', 'ResourceController@putUserBadge');
    Route::delete($route.'/users/{userId}/badges/{badgeId}', 'ResourceController@deleteUserBadge');
});

Route::get('/oauth/login', function()
{
    return View::make('simplelogin');
});




//APP RESTful Service
Route::group(array('before' => 'oauth:app|oauth-owner:user|restStatus'), function() {
    $route = "api";

    Route::get($route.'/badges', 'ApiController@getBadges'); //Show user badges (accepted)
    Route::get($route.'/badges/pending', 'ApiController@getBadgesPending'); //Show user badges (!accepted)
    Route::post($route.'/badges/pending/accept', 'ApiController@acceptBadgePending'); //Accept badge
    Route::get($route.'/badges/public', 'ApiController@getBadgesPublic'); //Show user badges (public)
    Route::get($route.'/badges/{badgeId}', 'ApiController@getBadge'); //Show unique badge
    Route::get($route.'/badges/{badgeId}/tags', 'ApiController@getBadgeTags'); //Show tags from badge
    Route::post($route.'/badges/{badgeId}/tags/add', 'ApiController@addBadgeTags'); //Add tags to a badge
    Route::post($route.'/badges/{badgeId}/tags/remove', 'ApiController@deleteBadgeTags'); //Remove tags from a badge
    Route::post($route.'/badges/{badgeId}/tags/update', 'ApiController@updateBadgeTags'); //Update tags from a badge

    Route::get($route.'/tags', 'ApiController@getTags'); //Show user tags
    Route::get($route.'/tags/{tagName}', 'ApiController@getTag');  //Show unique tag
    Route::get($route.'/tags/{tagName}/badges', 'ApiController@getTagBadges');  //Show user badges with tag

    Route::get($route.'/mozilla/migrate', 'ApiController@mozillaMigrate');  //Show user badges with tag

});
//~~~~~~~~~~~~~~~~~~~~



Route::get('/oauth/logged', array('before' => 'oauth', function(){
    return "oauth secured route for users: ".ResourceServer::getOwnerId()." ".ResourceServer::getOwnerType();
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
