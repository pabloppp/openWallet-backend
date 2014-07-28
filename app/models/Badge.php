<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 21:19
 */

class Badge extends Eloquent{

    /**
    * id - AI
    * {
        * version [string(10)]
        * name [string(100)]
        * description [string(255)]
        * criteria [string(255)]
        * image_url [string(255)]
        * issuer_id -> Issuer(id) [integer]
    * } - UNIQUE
    * image [blob]
    * timestamps
    */

    /**
     * ON TABLE 'user_badge':
     * issued_on [timestamp]
     * added_on [timestamp]
     */

    protected $table = 'badges';
    protected $hidden = array('pivot');

    public function owners()
    {
        return $this->belongsToMany('User', 'user_badge');
    }

    public function issuer()
    {
        return $this->belongsTo('Issuer','issuer_id');
    }

    public function tags(){
        return $this->belongsToMany('Tag', 'badge_tag');
    }

    public function tagsByUser($user){
        return $this->belongsToMany('Tag','badge_tag')->where('tags.user_id', $user->id);
    }

    public function addTag($tag){

        $user_id = (int)$tag->user_id;
        $user = User::findOrFail($user_id);
        $owners = $this->owners;

        if(in_array($user->toArray(), $owners->toArray())){
            $this->tags()->attach($tag, array('tagged_on' => date('Y-m-d H:i:s', time())));
            return $this;
        }
        else{
            App::abort(403, 'Unauthorized action.');
        }
    }


}