<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 20:43
 */

class Account extends Eloquent{

    /**
     * id - AI
     * user_id -> User(id) [integer]
     * name [string(255)]
     * secret [string(255)]
     * recipient [string(255)] NULLABLE
     * account_type -> AccountType(id) [string(100)]
     * timestamps
     */

    protected $table = 'accounts';

    public function type()
    {
        return $this->belongsTo('AccountType','account_type');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function withUserAndType($u, $t){
        $this->user_id = $u->id;
        $this->account_type = $t->id;
        return $this;
    }

}