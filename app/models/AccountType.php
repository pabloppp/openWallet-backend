<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 20:43
 */

class AccountType extends Eloquent{

    /**
     * id - [string(100)]
     * name [string(255)]
     * description [string(255)] NULLABLE
     */

    protected $table = 'account_types';

    public $incrementing = false;
    public $timestamps = false;

    public function accounts()
    {
        return $this->hasMany('Account', 'account_type');
    }

}