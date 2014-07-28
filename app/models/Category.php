<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 27/07/14
 * Time: 23:55
 */

class Category extends Eloquent{

    /**
     * id - AI
     * {
     * origin [string(255)]
     * name [string(255)]
     * contact [string(255)]
     * } - UNIQUE
     */

    protected $table = 'categories';

    public $timestamps = false;


}