<?php

namespace IUT\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function homeAction()
    {

        return $this->render('IUTAdminBundle:Default:home.html.twig');
        return $this->redirectToRoute('iut_admin_connect');
    }

    public function connectAction()
    {
        return $this->render('IUTAdminBundle:Default:connect.html.twig');
    }
}
