<?php

namespace IUT\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{


    public function homeAction(Request $request)
    {



        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('IUT\CoreBundle\Form\ContactType',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('iut_core_home'),
            'method' => 'POST'
        ));



        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){

                if($this->sendEmail($form->getData())){
                    $request->getSession()->getFlashBag()->add('info', 'Le mail a été envoyé');
                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('iut_core_home');
                }else{
                    $request->getSession()->getFlashBag()->add('info', 'Une erreur à empêché la transmission... voici mon mail : guillaume.rachet@gmail.com ');

                }
            } else {$request->getSession()->getFlashBag()->add('info', 'Veuillez corriger les informations');}



        }

        $users = $em->getRepository('IUTAdminBundle:Users')->findAll();
        return $this->render('IUTCoreBundle:Default:home.html.twig', array('form'=> $form->createView(), 'listUsers' => $users));
    }

    public function pagePersoAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('IUTAdminBundle:Users')->findOneBy(array('id' => $id));

        $files = $em->getRepository('IUTAdminBundle:Files')->findBy(array('Users' => $user));

        return $this->render('IUTCoreBundle:Default:pagePerso.html.twig', array('user' => $user, 'listFiles' => $files));
    }









    private function sendEmail($data){


        $message = (new \Swift_Message($data["subject"]))
            ->setFrom($data["email"])
            ->setTo('guillaume.rachet@gmail.com')
            ->setBody($data["message"],
                'text/plain'
            );

        return $this->get('mailer')->send($message);
    }






}
