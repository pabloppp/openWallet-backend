<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * id - AI
     * username [string(255)]
     * password [string(255)]
     * remember_token [string(100)] NULLABLE
     * timestamps
     */

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token', 'pivot');


    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function accounts()
    {
        return $this->hasMany('Account');
    }

    public function badges()
    {
        return $this->belongsToMany('Badge', 'user_badge');
    }

    public function tags(){
        return $this->hasMany('Tag');
    }



    public function taggedBadges()
    {
        $badges = array();
        foreach ($this->tags as $tag){
            foreach ($tag->badges as $badge){
                $badges[] = $badge;
            }
        }
        sort($badges);
        return json_encode($badges);

    }



}
