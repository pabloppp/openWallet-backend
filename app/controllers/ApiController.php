<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 31/07/14
 * Time: 23:59
 */

class ApiController extends BaseController{

    protected $userId;

    function ApiController(){
        $this->userId = ResourceServer::getOwnerId();
    }

    public function getBadges(){
        $badges = User::findOrFail($this->userId)->badges();
        return $badges->get();
    }

    public function getBadgesPending(){
        $badges = User::findOrFail($this->userId)->pendingBadges();
        return $badges->lists('id');
    }

    public function acceptBadgePending(){

        $badgeId = Input::get('id');

        if(!isset($badgeId)) return Response::json(array("errors"=>array("message"=>"Missing parameter 'id'","code"=>400)),400);

        $badges = User::findOrFail($this->userId)->pendingBadges();
        $badge = $badges->findOrFail($badgeId);
        $badges->updateExistingPivot($badgeId, array("accepted" => true));
        //$badges->updateExistingPivot($badgeId, array("accepted" => true));
        return $badge->get(["id","version","name"]);
    }

    public function getBadgesPublic(){
        $badges = User::findOrFail($this->userId)->publicBadges();
        return $badges->get();
    }

    public function getBadge($badgeId){
        $badges = User::findOrFail($this->userId)->badges();
        $badge = $badges->findOrFail($badgeId);
        return $badge;

    }

    public function getBadgeTags($badgeId){
        $badges = User::findOrFail($this->userId)->badges();
        $badge = $badges->findOrFail($badgeId)->first();
        $tags = $badge->tagsByUserId($this->userId)->get();
        return $tags;

    }

    public function deleteBadgeTags($badgeId){
    $badges = User::findOrFail($this->userId)->badges();
    $badge = $badges->findOrFail($badgeId)->first();
    $tags = $badge->tagsByUserId($this->userId);

    $removed = 0;
    $error = 0;

    $tagNames = Input::get('tags');
    if(!isset($tagNames)) return Response::json(array("errors"=>array("message"=>"Missing parameter 'tags'","code"=>400)),400);
    $tagNameArray = explode('|', $tagNames);
    foreach($tagNameArray as $tagName){
        try{
            $tag = $badge->tags()->where("tag",$tagName)->firstOrFail();
            $tags->detach($tag);
            if($tag->badges()->count() == 0) $tag->delete();
            $removed++;
        }catch(Exception $e){
            $error++;
        }
    }
    return Response::json(array("sucess"=>array("message"=>"$removed tags removed. $error errors","code"=>200)),200);
}

    public function addBadgeTags($badgeId){

        $added = 0;
        $error = 0;
        $badges = User::findOrFail($this->userId)->badges();
        $badge = $badges->findOrFail($badgeId)->first();

        $tagNames = Input::get('tags');
        if(!isset($tagNames)) return Response::json(array("errors"=>array("message"=>"Missing parameter 'tags'","code"=>400)),400);

        $tagNameArray = explode('|', $tagNames);
        foreach($tagNameArray as $tagName){
            try{
                $newTag = Tag::create(array(
                    "tag" => $tagName,
                    "user_id" => $this->userId
                ));
            }
            catch(Exception $e){
                $newTag = Tag::where("tag",$tagName)->first();
            }
            try{
                $badge->tags()->attach($newTag, array(
                    'tagged_on' => date('Y-m-d H:i:s', time())
                ));
                $added++;
            }
            catch(Exception $e){
                $error++;
                //return Response::json(array("errors"=>array("message"=>"Missing parameter 'tags'","code"=>400)),400);
            }
        }
        return Response::json(array("sucess"=>array("message"=>"$added tags added. $error errors","code"=>200)),200);

    }

    public function updateBadgeTags($badgeId){
        $added = 0;
        $removed = 0;

        $badges = User::findOrFail($this->userId)->badges();
        $badge = $badges->findOrFail($badgeId)->first();
        $tags = $badge->tagsByUserId($this->userId);

        $tagNames = Input::get('tags');
        if(!isset($tagNames)) return Response::json(array("errors"=>array("message"=>"Missing parameter 'tags'","code"=>400)),400);
        $tagNameArray = explode('|', $tagNames);
        foreach($tags->get() as $tag){
           echo "calipo";
           $eraseable = true;
           foreach($tagNameArray as $tagName){
            if($tag->tag == $tagName) $eraseable = false;
           }
           if($eraseable){
               $removed++;
               $tags->detach($tag);
               if($tag->badges()->count() == 0) $tag->delete();
           }
        }
        foreach($tagNameArray as $tagName){
            try{
                $newTag = Tag::create(array(
                    "tag" => $tagName,
                    "user_id" => $this->userId
                ));
            }
            catch(Exception $e){
                $newTag = Tag::where("tag",$tagName)->first();
            }
            try{
                $badge->tags()->attach($newTag, array(
                    'tagged_on' => date('Y-m-d H:i:s', time())
                ));
                $added++;
            }
            catch(Exception $e){
                //return Response::json(array("errors"=>array("message"=>"Missing parameter 'tags'","code"=>400)),400);
            }
        }
        return Response::json(array("sucess"=>array("message"=>"$added tags added. $removed tags removed","code"=>200)),200);

    }

    public function getTags(){
        $tags = User::findOrFail($this->userId)->tags();
        return $tags->get();
    }

    public function getTag($tagName){
        $tags = User::findOrFail($this->userId)->tags();
        $tag = $tags->where("tag",$tagName)->firstOrFail();
        return $tag;
    }

    public function getTagBadges($tagName){
        $tags = User::findOrFail($this->userId)->tags();
        $tag = $tags->where("tag",$tagName)->firstOrFail();
        $badges = $tag->badges();
        return $badges->get();
    }


    public function mozillaMigrate(){

        $email = Input::get('email');
        if(!isset($email)) return Response::json(array("errors"=>array("message"=>"Missing parameter 'email'","code"=>400)),400);
        $validator = Validator::make(["email"=>$email], array(
            'email' => 'required|email'
        ));
        if ($validator->fails()){
            $messages = $validator->messages();
            return Response::json(array("errors"=>array("message"=>"Error validating email: $messages","code"=>400)),400);
        }
        return Mozilla::importBadges($email, User::findOrFail($this->userId));
    }


} 