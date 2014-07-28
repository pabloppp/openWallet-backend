<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 12:21
 */

class OAuthScope extends Eloquent{

    protected $table = 'oauth_scopes';

    protected $guarded = [];

    public function clients(){
        return $this->belongsToMany('OAuthClient', 'oauth_client_scopes', 'scope_id', 'client_id');
    }

}