<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 05/12/2018
 * Time: 23:33
 */

namespace AppBundle\DAO;

use AppBundle\model\Competence;
use \PDO;
use \PDOException;
use \stdClass;

class DAOCompetences extends DAO {

    /**
     * @param int $id
     * @return Competence|null
     * @throws DBException
     */
    public function readById(int $id){
        $competence = null;

        try{
            $requete = "SELECT * FROM competences WHERE id_comp = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

            if($row = $res->fetch(PDO::FETCH_OBJ)){
                $competence = new Competence(
                    $row->id_comp,
                    $row->nom,
                    $row->type,
                    $row->niveau,
                    $row->langage
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $competence;
    }

    /**
     * @param int $id
     * @return Competence[]
     * @throws DBException
     */
    public function readByTypeComp(int $id){
        $competences[] = null;

        try{
            $requete = "SELECT * FROM competences WHERE type = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':type' => $id));

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $competences[] = new Competence(
                    $row->id_comp,
                    $row->nom,
                    $row->type,
                    $row->niveau,
                    $row->langage
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $competences;
    }

    /**
     * @param int $id
     * @return Competence[]
     * @throws DBException
     */
    public function readByNiveauComp(int $id){
        $competences[] = null;

        try{
            $requete = "SELECT * FROM competences WHERE niveau = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':niveau' => $id));

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $competences[] = new Competence(
                    $row->id_comp,
                    $row->nom,
                    $row->type,
                    $row->niveau,
                    $row->langage
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $competences;
    }


    /**
     * @return stdClass
     * @throws DBException
     */
    public function readByViews(){
        $views = new stdClass();
        $view = array();

        try{
            $viewNames = array(
                'base_de_donnees',
                'cms',
                'conception',
                'design_patterns',
                'frameworks',
                'langages_de_programmation',
                'langue',
                'logiciels',
                'programmation_web',
                'qualite',
                'systemes_d_exploitation',
                'versioning'
            );

            $requete = 'SELECT * FROM ';

            foreach ($viewNames as $name) {
                $requete .= $name;
                $res = $this->_connex->query($requete);

                while($row = $res->fetch(PDO::FETCH_OBJ)){
                    $view[] = $row;
                }

                $views->{$name} = $view;
                $view = array();
                $requete = 'SELECT * FROM ';
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $views;
    }

    /**
     * @param Competence $comp
     * @throws DBException
     */
    public function create(Competence &$comp){
        $res = false;

        try{
            $requete = "INSERT INTO competences(nom, type, niveau, langage) VALUES(:nom, :type, :niveau, :langage)";

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':nom' => $comp->getNom(),
                ':type' => $comp->getType(),
                ':niveau' => $comp->getNiveau(),
                ':langage' => $comp->getLangage()
            );
            $res = $prep->execute($params);

            $comp->setIdComp($this->_connex->lastInsertId());

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }


    /**
     * @param int $id
     * @return bool
     * @throws DBException
     */
    public function delete(int $id){
        $res = false;

        try{
            $requete = "DELETE FROM competences WHERE id_comp = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @param Competence $comp
     * @return bool
     * @throws DBException
     */
    public function update(Competence $comp){
        $res = false;

        try{
            $requete ='UPDATE competences 
                       SET 
                          nom = :nom, 
                          type = :type, 
                          niveau = :niveau, 
                          langage = :langage 
                        WHERE id_comp = :id';

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':id' => $comp->getIdComp(),
                ':nom' => $comp->getNom(),
                ':type' => $comp->getType(),
                ':niveau' => $comp->getNiveau(),
                ':langage' => $comp->getLangage()
            );
            $res = $prep->execute($params);

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @return Competence[]|null
     * @throws DBException
     */
    public function readAll(){
        $competences = null;

        try{
            $requete = "SELECT * FROM competences";

            $res = $this->_connex->query($requete);

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $competences[] = new Competence(
                    $row->id_comp,
                    $row->nom,
                    $row->type,
                    $row->niveau,
                    $row->langage
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $competences;
    }

}