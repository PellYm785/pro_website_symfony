<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 05/12/2018
 * Time: 23:23
 */

namespace AppBundle\DAO;

use \PDO;

/**
 * Class SingletonConnectionDatabase
 * @package DAO
 */

class SingletonConnectionDatabase
{

    /**
     * @var PDO
     */
    private static $bdd = null;

    /**
     * SingletonConnectionDatabase constructor.
     */
    private function __construct($dsn, $user, $pass){
        try {
            self::$bdd = new PDO($dsn, $user, $pass);
        }catch (\PDOException $exception){
            throw new DBException($exception->getMessage());
        }
    }


    /**
     * @return PDO
     */
    public static function getInstance($dsn, $user, $pass){
        if(!self::$bdd){
            new self($dsn, $user, $pass);
        }

        return self::$bdd;
    }
}