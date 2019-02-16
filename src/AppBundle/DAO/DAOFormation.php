<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 19:03
 */

namespace AppBundle\DAO;


use AppBundle\Model\Formation;
use \PDO;
use \PDOException;

class DAOFormation extends DAO {
    /**
     * @param int $id
     * @return Formation|null
     * @throws DBException
     */
    public function readById(int $id){
        $formation = null;

        try{
            $requete = "SELECT * FROM formation WHERE id_form = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

            if($row = $res->fetch(PDO::FETCH_OBJ)){
                $formation = new Formation(
                    $row->id_form,
                    $row->nom,
                    $row->etablissement,
                    $row->ville,
                    date_parse($row->debut),
                    $row->fin != '0000-00-00' ? date_parse($row->fin): '0000-00-00',
                    $row->commentaire
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $formation;
    }

    /**
     * @param Formation $form
     * @return bool
     * @throws DBException
     */
    public function create(Formation $form){
        $res = false;

        try{
            $requete = "INSERT INTO formation(nom, etablissement, ville, debut, fin, commentaire) VALUES(:nom, :etablissement, :ville, :debut, :fin, :commentaire)";

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':nom' => $form->getNom(),
                ':etablissement' => $form->getEtablissement(),
                ':ville' => $form->getVille(),
                ':debut' => $form->getDebut(),
                ':fin' => $form->getFin(),
                ':commentaire' => $form->getCommentaire()
            );
            $res = $prep->execute($params);

            $form->setIdComp($this->_connex->lastInsertId());

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
            $requete = "DELETE FROM formation WHERE id_form = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @param Formation $form
     * @return bool
     * @throws DBException
     */
    public function update(Formation $form){
        $res = false;

        try{
            $requete ='UPDATE formation 
                       SET 
                          nom = :nom, 
                          etablissement = :etablissement, 
                          ville = :ville, 
                          debut = :debut,
                          fin = :fin,
                          commentaire = :commentaire 
                        WHERE id_form = :id';

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':id' => $form->getIdForm(),
                ':nom' => $form->getNom(),
                ':etablissement' => $form->getEtablissement(),
                ':ville' => $form->getVille(),
                ':debut' => $form->getDebut(),
                ':fin' => $form->getFin(),
                ':commentaire' => $form->getCommentaire()
            );
            $res = $prep->execute($params);

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @return Formation[]|null
     * @throws DBException
     */
    public function readAll(){
        $formations = null;

        try{
            $requete = "SELECT * FROM formation";

            $res = $this->_connex->query($requete);

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $formations[] = new Formation(
                    $row->id_form,
                    $row->nom,
                    $row->etablissement,
                    $row->ville,
                    date_parse($row->debut),
                    $row->fin != '0000-00-00' ? date_parse($row->fin): '0000-00-00',
                    $row->commentaire
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $formations;
    }
}