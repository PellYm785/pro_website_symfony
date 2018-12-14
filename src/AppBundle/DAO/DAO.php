<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 05/12/2018
 * Time: 23:29
 */

namespace AppBundle\DAO;


/**
 * Class DAO
 * @package DAO
 */
abstract class DAO
{
    /**
     * @var PDO $_connex
     */
    protected $_connex;

    /**
     * DAO constructor.
     */
    public function __construct($dsn, $user, $pass)
    {
        $this->_connex = SingletonConnectionDatabase::getInstance($dsn, $user, $pass);
    }

}