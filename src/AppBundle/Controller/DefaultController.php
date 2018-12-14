<?php

namespace AppBundle\Controller;

use AppBundle\DAO\DAOCompetences;
use AppBundle\DAO\DAOExperience;
use AppBundle\DAO\DAOFormation;
use AppBundle\DAO\DAONiveauComp;
use AppBundle\DAO\DAOTypeComp;
use AppBundle\model\Cv;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if (file_exists('../src/AppBundle/model/LM.xml')) {
            $xml = simplexml_load_file('../src/AppBundle/model/LM.xml');
        } else {
            exit('Echec lors de l\'ouverture du fichier LM.xml.');
        }
        $cv = null;
        $comps = null;

        $container = $this->container;

        $dsn = 'mysql:host=' .
            $container->getParameter('database_host') . ';dbname=' . $container->getParameter('database_name') . ';charset=UTF8';
        $user = $container->getParameter('database_user');
        $pass = $container->getParameter('database_password');
        $daoComp = new DAOCompetences($dsn, $user, $pass);
        $daoForm = new DAOFormation($dsn, $user, $pass);
        $daoTypeComp = new DAOTypeComp($dsn, $user, $pass);
        $daoNiveauComp = new DAONiveauComp($dsn, $user, $pass);
        $daoExp = new DAOExperience($dsn, $user, $pass);

        $comps = $daoComp->readByViews();
        $forms = $daoForm->readAll();
        $typeComp = $daoTypeComp->readAll();
        $niveauComp = $daoNiveauComp->readAll();
        $exps = $daoExp->readAll();

        $cv = new Cv($forms, $typeComp, $niveauComp, $comps, $exps);

        // replace this example code with whatever you need
        return $this->render('index/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'lm' => $xml,
            'cv' => $cv
        ]);
    }

    /**
     * @Route("/getCvJSON", name="cv_json")
     */
    public function getCv(Request $request){
        $cv = null;
        $comps = null;

        $container = $this->container;

        $dsn = 'mysql:host=' .
            $container->getParameter('database_host') . ';dbname=' . $container->getParameter('database_name') . ';charset=UTF8';
        $user = $container->getParameter('database_user');
        $pass = $container->getParameter('database_password');
        $daoComp = new DAOCompetences($dsn, $user, $pass);
        $daoForm = new DAOFormation($dsn, $user, $pass);
        $daoTypeComp = new DAOTypeComp($dsn, $user, $pass);
        $daoNiveauComp = new DAONiveauComp($dsn, $user, $pass);
        $daoExp = new DAOExperience($dsn, $user, $pass);

        $comps = $daoComp->readByViews();
        $forms = $daoForm->readAll();
        $typeComp = $daoTypeComp->readAll();
        $niveauComp = $daoNiveauComp->readAll();
        $exps = $daoExp->readAll();

        $cv = new Cv($forms, $typeComp, $niveauComp, $comps, $exps);

        return new JsonResponse($cv);
    }

    /**
     * @Route("/sendMail", name="sendMail")
     */
    public function sendMail(Request $request, Swift_Mailer $mailer)
    {
        $message = (new Swift_Message($request->request->get('objet')))
            ->setFrom($request->request->get('email'))
            ->setTo('william.ngbama@gmail.com')
            ->setBody(
                $request->request->get('message'),
                'text/html'
            )
        ;

        $mailer->send($message, $error);
        var_dump($error);
        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

        return new JsonResponse($error);
    }

}
