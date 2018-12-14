<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 18:37
 */

namespace AppBundle\DAO;


use AppBundle\model\TypeComp;
use \PDO;
use \PDOException;

class DAOTypeComp extends DAO {
    /**
     * @param int $id
     * @return TypeComp|null
     * @throws DBException
     */
    public function readById(int $id){
        $typeComp = null;

        try{
            $requete = "SELECT * FROM typecomp WHERE id = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

            if($row = $res->fetch(PDO::FETCH_OBJ)){
                $typeComp = new TypeComp(
                    $row->id,
                    $row->type
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $typeComp;
    }


    /**
     * @param TypeComp $typeComp
     * @return bool
     * @throws DBException
     */
    public function create(TypeComp &$typeComp){
        $res = false;

        try{
            $requete = "INSERT INTO typecomp(type) VALUES(:type)";

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':type' => $typeComp->getType()
            );
            $res = $prep->execute($params);

            $typeComp->setId($this->_connex->lastInsertId());

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

            $comps = $daoComp->readByTypeComp();

            foreach ($comps as $comp){
                $comp->setType(null);
                $daoComp->update($comp);
            }

            $requete = 'DELETE FROM typecomp WHERE id = :id';

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @param TypeComp $typeComp
     * @return bool
     * @throws DBException
     */
    public function update(TypeComp $typeComp){
        $res = false;

        try{
            $requete ='UPDATE typecomp 
                       SET 
                          type = :type, 
                        WHERE id = :id';

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':id' => $typeComp->getId(),
                ':type' => $typeComp->getType()
            );
            $res = $prep->execute($params);

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @return TypeComp[]|null
     * @throws DBException
     */
    public function readAll(){
        $typeCompetences = null;

        try{
            $requete = "SELECT * FROM typecomp";

            $res = $this->_connex->query($requete);

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $typeCompetences[] = new TypeComp(
                    $row->id,
                    $row->type
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $typeCompetences;
    }
}