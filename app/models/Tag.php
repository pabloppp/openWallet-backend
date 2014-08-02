<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 28/07/14
 * Time: 00:20
 */

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Tag extends Eloquent{

    /**
     * id - [string(255)]
     * {
     * tag [string(255)]
     * user_id [integer]
     * } UNIQUE
     * account_id -> Account [integer] NULLABLE
     * timestamps
     */

    protected $table = 'tags';

    protected $hidden = array('pivot','user_id','id');
    protected $fillable = array('tag', 'user_id');

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function account() //can return NULL
    {
        return $this->belongsTo('Account');
    }

    public function badges()
    {
        return $this->belongsToMany('Badge', 'badge_tag');
    }

    public function by($user){ //set the user that made the tag
        $this->user_id = $user->id;
        return $this;
    }

    public function tagBadge($badge){

        $user_id = (int)$this->user_id;
        $user = User::findOrFail($user_id);
        $owners = $badge->owners;

        if(in_array($user->toArray(), $owners->toArray())){
            $badge->tags()->attach($this, array('tagged_on' => date('Y-m-d H:i:s', time())));
            return $this;
        }
        else{
            App::abort(403, 'Unauthorized action.');
        }
    }

}