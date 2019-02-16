<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 19:27
 */

namespace AppBundle\DAO;


use AppBundle\Model\NiveauComp;
use \PDO;
use \PDOException;


class DAONiveauComp extends DAO {
    /**
     * @param int $id
     * @return NiveauComp|null
     * @throws DBException
     */
    public function readById(int $id){
        $niveauComp = null;

        try{
            $requete = "SELECT * FROM niveaucomp WHERE id = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

            if($row = $res->fetch(PDO::FETCH_OBJ)){
                $niveauComp = new NiveauComp(
                    $row->id,
                    $row->niveau
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $niveauComp;
    }


    /**
     * @param NiveauComp $niveauComp
     * @return bool
     * @throws DBException
     */
    public function create(NiveauComp &$niveauComp){
        $res = false;

        try{
            $requete = "INSERT INTO niveaucomp(niveau) VALUES(:niveau)";

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':niveau' => $niveauComp->getNiveau()
            );
            $res = $prep->execute($params);

            $niveauComp->setId($this->_connex->lastInsertId());

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
            $daoComp = new DAOCompetences();

            $comps = $daoComp->readByNiveauComp();

            foreach ($comps as $comp){
                $comp->setNiveau(null);
                $daoComp->update($comp);
            }

            $requete = 'DELETE FROM niveaucomp WHERE id = :id';

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @param NiveauComp $niveauComp
     * @return bool
     * @throws DBException
     */
    public function update(NiveauComp $niveauComp){
        $res = false;

        try{
            $requete ='UPDATE niveaucomp 
                       SET 
                          niveau = :niveau, 
                        WHERE id = :id';

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':id' => $niveauComp->getId(),
                ':niveau' => $niveauComp->getNiveau()
            );
            $res = $prep->execute($params);

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @return NiveauComp[]|null
     * @throws DBException
     */
    public function readAll(){
        $niveauCompetences = null;

        try{
            $requete = "SELECT * FROM niveaucomp";

            $res = $this->_connex->query($requete);

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $niveauCompetences[] = new NiveauComp(
                    $row->id,
                    $row->niveau
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $niveauCompetences;
    }
}