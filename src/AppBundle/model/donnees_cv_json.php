<?php

/**
 * @author willi
 *
 */
//define(ABSPATH, str_replace('\\', '/', __DIR__));

require_once '../vendor/autoload.php';

use \DAO\DAOExperience;
use \DAO\DAOFormation;
use \DAO\DAONiveauComp;
use \DAO\DAOTypeComp;
use \model\Cv;
use DAO\DAOCompetences;

header('Content-Type: application/json');

$cv = null;
$comps = null;


$daoComp = new DAOCompetences();
$daoForm = new DAOFormation();
$daoTypeComp = new DAOTypeComp();
$daoNiveauComp = new DAONiveauComp();
$daoExp = new DAOExperience();

$comps = $daoComp->readByViews();
$forms = $daoForm->readAll();
$typeComp = $daoTypeComp->readAll();
$niveauComp = $daoNiveauComp->readAll();
$exps = $daoExp->readAll();

$cv = new Cv($forms, $typeComp, $niveauComp, $comps, $exps);

echo json_encode($cv);

?>


