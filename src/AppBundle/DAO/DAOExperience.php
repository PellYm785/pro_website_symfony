<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 09/12/2018
 * Time: 23:55
 */

namespace AppBundle\DAO;


use AppBundle\Model\Experience;
use \PDO;
use \PDOException;

class DAOExperience extends DAO {
    /**
     * @param int $id
     * @return Experience|null
     * @throws DBException
     */
    public function readById(int $id){
        $experience = null;

        try{
            $requete = "SELECT * FROM experience WHERE id = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

            if($row = $res->fetch(PDO::FETCH_OBJ)){
                $experience = new Experience(
                    $row->id,
                    $row->poste,
                    date_parse($row->debut),
                    $row->fin != '0000-00-00' ? date_parse($row->fin): '0000-00-00',
                    $row->organisation,
                    $row->type
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $experience;
    }


    /**
     * @param Experience $exp
     * @throws DBException
     */
    public function create(Experience &$exp){
        $res = false;

        try{
            $requete = "INSERT INTO experience(poste, debut, fin, organisation, type) VALUES(:poste, :debut, :fin, :organisation, :type)";

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':poste' => $exp->getPoste(),
                ':debut' => $exp->getDebut(),
                ':fin' => $exp->getFin(),
                ':organisation' => $exp->getOrganisation(),
                ':type' => $exp->getType()
            );
            $res = $prep->execute($params);

            $exp->setIdComp($this->_connex->lastInsertId());

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
            $requete = "DELETE FROM experience WHERE id = :id";

            $prep = $this->_connex->prepare($requete);

            $res = $prep->execute(array(':id' => $id));

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @param Experience $exp
     * @return bool
     * @throws DBException
     */
    public function update(Experience $exp){
        $res = false;

        try{
            $requete ='UPDATE experience 
                       SET 
                          poste = :poste, 
                          debut = :debut, 
                          fin = :fin, 
                          organisation = :organisation,
                          type = :type
                        WHERE id = :id';

            $prep = $this->_connex->prepare($requete);

            $params = array(
                ':id' => $exp->getId(),
                ':poste' => $exp->getPoste(),
                ':debut' => $exp->getDebut(),
                ':fin' => $exp->getFin(),
                ':organisation' => $exp->getOrganisation(),
                ':type' => $exp->getType()
            );
            $res = $prep->execute($params);

        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $res;
    }

    /**
     * @return Experience[]|null
     * @throws DBException
     */
    public function readAll(){
        $experiences = null;

        try{
            $requete = "SELECT * FROM experience";

            $res = $this->_connex->query($requete);

            while($row = $res->fetch(PDO::FETCH_OBJ)){
                $experiences[] = new Experience(
                    $row->id,
                    $row->poste,
                    date_parse($row->debut),
                    $row->fin != '0000-00-00' ? date_parse($row->fin): '0000-00-00',
                    $row->organisation,
                    $row->type
                );
            }
        }catch (PDOException $exception){
            throw new DBException($exception->getMessage());
        }

        return $experiences;
    }
}