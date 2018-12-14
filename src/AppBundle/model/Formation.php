<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 00:58
 */

namespace AppBundle\model;

use \JsonSerializable;

class Formation implements JsonSerializable{
    private $_id_form;
    private $_nom;
    private $_etablissement;
    private $_ville;
    private $_debut;
    private $_fin;
    private $_commentaire;

    /**
     * Formation constructor.
     * @param $_id_form
     * @param $_nom
     * @param $_etablissement
     * @param $_ville
     * @param $_debut
     * @param $_fin
     * @param $_commentaire
     */
    public function __construct($_id_form, $_nom, $_etablissement, $_ville, $_debut, $_fin, $_commentaire)
    {
        $this->_id_form = $_id_form;
        $this->_nom = $_nom;
        $this->_etablissement = $_etablissement;
        $this->_ville = $_ville;
        $this->_debut = $_debut;
        $this->_fin = $_fin;
        $this->_commentaire = $_commentaire;
    }

    /**
     * @return mixed
     */
    public function getIdForm()
    {
        return $this->_id_form;
    }

    /**
     * @param mixed $id_form
     */
    public function setIdForm($id_form)
    {
        $this->_id_form = $id_form;
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
    public function getEtablissement()
    {
        return $this->_etablissement;
    }

    /**
     * @param mixed $etablissement
     */
    public function setEtablissement($etablissement)
    {
        $this->_etablissement = $etablissement;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->_ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->_ville = $ville;
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
    public function getCommentaire()
    {
        return $this->_commentaire;
    }

    /**
     * @param mixed $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->_commentaire = $commentaire;
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