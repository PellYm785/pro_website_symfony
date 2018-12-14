<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 00:57
 */

namespace AppBundle\model;

use \JsonSerializable;

class Experience implements JsonSerializable{
    private $_id;
    private $_poste;
    private $_debut;
    private $_fin;
    private $_organisation;
    private $_type;

    /**
     * Experience constructor.
     * @param $_id
     * @param $_poste
     * @param $_debut
     * @param $_fin
     * @param $_organisation
     * @param $_type
     */
    public function __construct($_id, $_poste, $_debut, $_fin, $_organisation, $_type)
    {
        $this->_id = $_id;
        $this->_poste = $_poste;
        $this->_debut = $_debut;
        $this->_fin = $_fin;
        $this->_organisation = $_organisation;
        $this->_type = $_type;
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
    public function getPoste()
    {
        return $this->_poste;
    }

    /**
     * @param mixed $poste
     */
    public function setPoste($poste)
    {
        $this->_poste = $poste;
    }

    /**
     * @return mixed
     */
    public function getDebut()
    {
        return $this->_debut;
    }

    /**
     * @param mixed $debut
     */
    public function setDebut($debut)
    {
        $this->_debut = $debut;
    }

    /**
     * @return mixed
     */
    public function getFin()
    {
        return $this->_fin;
    }

    /**
     * @param mixed $fin
     */
    public function setFin($fin)
    {
        $this->_fin = $fin;
    }

    /**
     * @return mixed
     */
    public function getOrganisation()
    {
        return $this->_organisation;
    }

    /**
     * @param mixed $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->_organisation = $organisation;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
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