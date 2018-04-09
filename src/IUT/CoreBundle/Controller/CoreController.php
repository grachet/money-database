<?php

namespace IUT\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{


    public function homeAction()
    {

        $em = $this->getDoctrine()->getManager();


        $users = $em->getRepository('IUTAdminBundle:Users')->findby(array(),null,20,2);


        return $this->render('IUTCoreBundle:Default:home.html.twig', array('listUsers' => $users));
    }

    public function pagePersoAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('IUTAdminBundle:Users')->findOneBy(array('id' => $id));

        $files = $em->getRepository('IUTAdminBundle:Files')->findBy(array('Users' => $user));

        return $this->render('IUTCoreBundle:Default:pagePerso.html.twig', array('user' => $user, 'listFiles' => $files));
    }
















}
