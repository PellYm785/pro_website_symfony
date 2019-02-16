<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 00:59
 */


namespace AppBundle\Model;

use \JsonSerializable;

class NiveauComp implements JsonSerializable{
    private $_id;
    private $_niveau;

    /**
     * NiveauComp constructor.
     * @param $_id
     * @param $_niveau
     */
    public function __construct($_id, $_niveau)
    {
        $this->_id = $_id;
        $this->_niveau = $_niveau;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getNiveau()
    {
        return $this->_niveau;
    }

    /**
     * @param mixed $niveau
     */
    public function setNiveau($niveau)
    {
        $this->_niveau = $niveau;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}