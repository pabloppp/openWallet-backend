<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 22:49
 */

class Issuer extends Eloquent{

    /**
    * id - AI
    * {
        * origin [string(255)]
        * name [string(255)]
        * contact [string(255)]
    * } - UNIQUE
    */

    protected $table = 'issuers';

    public $timestamps = false;

    public function badges()
    {
        return $this->hasMany('Badge','issuer_id');
    }

}