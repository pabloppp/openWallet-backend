<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 03:20
 */

class OAuthClient extends Eloquent{

    protected $table = 'oauth_clients';

    protected $guarded = [];

    public $incrementing = false;

    public function grants(){
        return $this->belongsToMany('OAuthClient', 'oauth_client_grants', 'client_id', 'grant_id');
    }

    public function scopes(){
        return $this->belongsToMany('OAuthClient', 'oauth_client_scopes', 'client_id', 'scope_id');
    }

}