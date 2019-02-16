<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 05/12/2018
 * Time: 23:29
 */

namespace AppBundle\DAO;


use PDO;

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
    public function __construct($_connex)
    {
        $this->_connex = $_connex;
    }

}