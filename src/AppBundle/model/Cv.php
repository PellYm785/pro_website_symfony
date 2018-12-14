<?php
namespace AppBundle\model;

use \JsonSerializable;

class Cv implements JsonSerializable {
    private $formations;
    private $typeComp;
    private $typeNiveau;
    private $competences;
    private $experiences;

    function __construct($formations,$typeComp,$typeNiveau,$competences,$experiences){
        $this->formations = $formations;
        $this->typeComp =  $typeComp;
        $this->typeNiveau = $typeNiveau;
        $this->competences = $competences;
        $this->experiences = $experiences;
    }
    /**
     * @return mixed
     */
    public function getFormations(){
        return $this->formations;
    }

    /**
     * @return mixed
     */
    public function getTypeComp(){
        return $this->typeComp;
    }

    /**
     * @return mixed
     */
    public function getTypeNiveau(){
        return $this->typeNiveau;
    }

    /**
     * @return mixed
     */
    public function getCompetences(){
        return $this->competences;
    }

    /**
     * @return mixed
     */
    public function getExperiences(){
        return $this->experiences;
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
?>