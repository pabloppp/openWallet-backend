<?php

class ResourceController extends BaseController {

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

    //GET ALL BADGES (!)
    public function getBadges(){ //called in api/badges
        $badges = Badge::all();
        return $badges;
    }
    //~~~~~~~~~~~~~~~~~~~~~


    //GET BADGE BY ID
    public function getBadge($badgeId){ //called in api/badges/{badgeId}
        $badge = Badge::find($badgeId);
        if($badge != null){
            return $badge;
        }
        else{
            $error = array("error" => "404", "message"=>"Badge not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~

    //GET BADGE (BY ID) OWNERS
    public function getBadgeOwners($badgeId){ //called in api/badges/{badgeId}
        $badge = Badge::find($badgeId);
        if($badge != null){
            $owners = $badge->owners;
            if(sizeof($owners) == 0){
                $error = array("error" => "404", "message"=>"Not owners found");
                return Response::json($error,"404");
            }
            else return $owners;
        }
        else{
            $error = array("error" => "404", "message"=>"Badge not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~


    //GET ALL USERS(!)
    public function getUsers(){ //called in api/users
        $badges = User::all();
        return $badges;
    }
    //~~~~~~~~~~~~~~~~~~~~~


    //GET USER BY ID
    public function getUser($userId){ //called in api/users/{userId}
        $user = User::find($userId);
        if($user != null) return $user;
        else{
            $error = array("error" => "404", "message"=>"User not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~


    //GET ALL BADGES FROM A USER (BY ID)
    public function getUserBadges($userId){ //called in api/users/{userId}/badges
        $user = User::find($userId);
        if($user != null){
            $badges = $user->badges;
            if(sizeof($badges) == 0){
                $error = array("error" => "404", "message"=>"No badges to show");
                return Response::json($error,"404");
            }
            else{
                return $badges;
            }
        }
        else{
            $error = array("error" => "404", "message"=>"User not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~

    //GET ONE BADGE (BY ID) FROM A USER (BY ID)
    public function getUserBadge($userId, $badgeId){ //called in api/users/{userId}/badges/{badgeId}
        $user = User::find($userId);
        if($user != null){
            $badges = $user->badges;
            $badge = $badges->find($badgeId);
            if($badge != null){
                return $badge;
            }
            else{
                $error = array("error" => "404", "message"=>"Badge not found");
                return Response::json($error,"404");
            }
        }
        else{
            $error = array("error" => "404", "message"=>"User not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~


    //REMOVE ONE BADGE (BY ID) FROM A USER (BY ID)
    public function deleteUserBadge($userId, $badgeId){ //called in api/users/{userId}/badges/{badgeId}
        $user = User::find($userId);
        if($user != null){
            $badges = $user->badges;
            $badge = $badges->find($badgeId);
            if($badge != null){
                $user->badges()->detach($badge);
                $user->save();
                $error = array("sucess" => "201", "message"=>"Badge removed from user");
                return Response::json($error,"201");
            }
            else{
                $error = array("error" => "404", "message"=>"Badge not found");
                return Response::json($error,"404");
            }
        }
        else{
            $error = array("error" => "404", "message"=>"User not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~

    //ADD ONE EXISTING BADGE (BY ID) TO A USER (BY ID)
    public function putUserBadge($userId, $badgeId){ //called in api/users/{userId}/badges/{badgeId}
        $user = User::find($userId);
        if($user != null){
            $userbadges = $user->badges->find($badgeId);
            if(sizeof($userbadges) != 0){
                $error = array("sucess" => "200", "message"=>"Badge already owned by user");
                return Response::json($error,"200");
            }
            $badge = Badge::find($badgeId);
            if($badge != null){
                $user->badges()->attach($badge,  array(
                    'issued_on' => date('Y-m-d H:i:s', time()),
                    'added_on' => date('Y-m-d H:i:s', time())
                ));
                $user->save();
                $error = array("sucess" => "201", "message"=>"Badge added to user");
                return Response::json($error,"201");
            }
            else{
                $error = array("error" => "404", "message"=>"Badge not found");
                return Response::json($error,"404");
            }
        }
        else{
            $error = array("error" => "404", "message"=>"User not found");
            return Response::json($error,"404");
        }
    }
    //~~~~~~~~~~~~~~~~~~~~~

    public function jsonFetchMozilla($userEmail){
        $userKeyJson = file_get_contents('url_here');
    }



}