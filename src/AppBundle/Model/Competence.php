<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 00:56
 */

namespace AppBundle\Model;


use \JsonSerializable;

class Competence implements JsonSerializable{
    private $_id_comp;
    private $_nom;
    private $_type;
    private $_niveau;
    private $_langage;

    /**
     * Competence constructor.
     * @param $_id_comp
     * @param $_nom
     * @param $_type
     * @param $_niveau
     * @param $_langage
     */
    public function __construct($_id_comp, $_nom, $_type, $_niveau, $_langage)
    {
        $this->_id_comp = $_id_comp;
        $this->_nom = $_nom;
        $this->_type = $_type;
        $this->_niveau = $_niveau;
        $this->_langage = $_langage;
    }

    /**
     * @return mixed
     */
    public function getIdComp()
    {
        return $this->_id_comp;
    }

    /**
     * @param mixed $id_comp
     */
    public function setIdComp($id_comp)
    {
        $this->_id_comp = $id_comp;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->_nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->_nom = $nom;
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
     * @return mixed
     */
    public function getLangage()
    {
        return $this->_langage;
    }

    /**
     * @param mixed $langage
     */
    public function setLangage($langage)
    {
        $this->_langage = $langage;
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