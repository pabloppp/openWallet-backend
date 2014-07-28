<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 03:44
 */

class OAuthGrant extends Eloquent{

    protected $table = 'oauth_grants';

    protected $guarded = [];

    public function clients(){
        return $this->belongsToMany('OAuthGrant', 'oauth_client_grants', 'grant_id', 'client_id');
    }

}