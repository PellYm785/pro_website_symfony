<?php

namespace AppBundle\Controller;

use AppBundle\DAO\DAOCompetences;
use AppBundle\DAO\DAOExperience;
use AppBundle\DAO\DAOFormation;
use AppBundle\DAO\DAONiveauComp;
use AppBundle\DAO\DAOTypeComp;
use AppBundle\DAO\DBException;
use AppBundle\Model\Cv;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/lettre-de-motivation", name="lmpage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lmAction()
    {
        if (file_exists(__DIR__ . '/../Model/LM.xml')) {
            $xml = simplexml_load_file(__DIR__ . '/../Model/LM.xml');
        } else {
            exit('Echec lors de l\'ouverture du fichier LM.xml.');
        }

        return $this->render('lm.html.twig', [
            'xml' => $xml,
            'page' => 'lm'
        ]);
    }

    /**
     * @Route("/curriculum-vitae", name="cvpage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cvAction()
    {
        $cv = null;
        $comps = null;

        $connec = $this->getDoctrine()->getConnection();

        $daoComp = new DAOCompetences($connec);
        $daoForm = new DAOFormation($connec);
        $daoTypeComp = new DAOTypeComp($connec);
        $daoNiveauComp = new DAONiveauComp($connec);
        $daoExp = new DAOExperience($connec);

        try {
            $comps = $daoComp->readByViews();
            $forms = $daoForm->readAll();
            $typeComp = $daoTypeComp->readAll();
            $niveauComp = $daoNiveauComp->readAll();
            $exps = $daoExp->readAll();
        } catch (DBException $exception) {
            echo $exception->getMessage();
        }
        if (!empty($typeComp) && !empty($comps) && !empty($niveauComp) && !empty($exps) && !empty($forms)) {
            $cv = new Cv($forms, $typeComp, $niveauComp, $comps, $exps);
        }

        return $this->render('cv.html.twig', [
            'cv' => $cv,
            'page' => 'cv'
        ]);
    }

    /**
     * @Route("/contact", name="contactpage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        return $this->render('contact.html.twig', [
            'page' => 'contact'
        ]);
    }

    /**
     * @Route("/sendMail", name="sendMail")
     * @param Request $request
     * @param Swift_Mailer $mailer
     * @return JsonResponse
     */
    public function sendMail(Request $request, Swift_Mailer $mailer)
    {
        $message = (new Swift_Message($request->request->get('objet')))
            ->setFrom($request->request->get('email'))
            ->setTo('william.ngbama@gmail.com')
            ->setBody(
                $request->request->get('message'),
                'text/html'
            );

        $error = null;
        $mailer->send($message, $error);
        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

        return new JsonResponse($error);
    }

    /**
     *
     * @Route("/", name="indexPage")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('lmpage');
    }
}
