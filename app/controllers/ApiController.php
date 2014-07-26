<?php

class ApiController extends BaseController {

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

    public function getIndex()  //called in api/
    {
        return "get!";
    }

    public function postIndex(){ //called in api/
        return "post!";
    }

    public function getBadges(){ //called in api/badges
        return "getBadge!";
    }

}