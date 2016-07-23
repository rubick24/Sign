<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 9:42
 */

namespace Common;


class Factory
{
    static function createDatabase(){
        $db = Database::getInstance();
        return $db;
    }

    static function createUser(){
        $user = User::getInstance();
        return $user;
    }
}