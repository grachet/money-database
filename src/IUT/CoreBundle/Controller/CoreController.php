<?php

namespace IUT\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function onepageAction()
    {
        return $this->render('IUTCoreBundle:Default:onepage.html.twig');
    }

    public function homeAction()
    {
        return $this->render('IUTCoreBundle:Default:home.html.twig');
    }

    public function listpersoAction()
    {
        return $this->render('IUTCoreBundle:Default:listperso.html.twig');
    }

    public function pagepersoAction()
    {
        return $this->render('IUTCoreBundle:Default:pageperso.html.twig');
    }















}
