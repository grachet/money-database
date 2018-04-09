<?php

namespace IUT\AdminBundle\Controller;

use IUT\AdminBundle\Entity\Coins;
use IUT\AdminBundle\Entity\Currencies;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

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

    public function modProfilAction(Request $request)
    {

        $id = 172;

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('IUTAdminBundle:Users')->findOneBy(array('id' => $id));

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        $formBuilder
            ->add('name',      TextType::class)
            ->add('description',     TextareaType::class)
            ->add('urlPicture',   TextType::class)
            ->add('Enregistrer',      SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
            $form->handleRequest($request);

            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info','Le profil a été modifié');

            }
        }


        return $this->render('IUTAdminBundle:Default:modProfil.html.twig', array(
            'form' => $form->createView(),'user' => $user) );
    }

    public function tabUsersAction()
    {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('IUTAdminBundle:Users')->findAll();


        return $this->render('IUTAdminBundle:Default:tabUsers.html.twig', array('listUsers' => $users) );

    }

    public function tabImagesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('IUTAdminBundle:Images')->findAll();


        return $this->render('IUTAdminBundle:Default:tabImages.html.twig', array('listImages' => $images) );

    }

    public function tabFilesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('IUTAdminBundle:Files')->findAll();


        return $this->render('IUTAdminBundle:Default:tabFiles.html.twig', array('listFiles' => $files) );

    }

    public function tabCoinsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $coins = $em->getRepository('IUTAdminBundle:Coins')->findAll();


        return $this->render('IUTAdminBundle:Default:tabCoins.html.twig', array('listCoins' => $coins) );

    }

    public function tabCurrenciesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $currencies = $em->getRepository('IUTAdminBundle:Currencies')->findAll();


        return $this->render('IUTAdminBundle:Default:tabCurrencies.html.twig', array('listCurrencies' => $currencies) );

    }


    public function modPassAction(Request $request)
    {

        $id = 165;

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('IUTAdminBundle:Users')->findOneBy(array('id' => $id));

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        $formBuilder
            ->add('password',      PasswordType::class)
            ->add('Enregistrer',      SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info','Le mot de passe a été modifié');

            }
        }


        return $this->render('IUTAdminBundle:Default:modPass.html.twig', array(
            'form' => $form->createView(),'user' => $user) );
    }

    public function addCurrenciesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();



        $currencie = new Currencies();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $currencie);

        $formBuilder
            ->add('name',      TextType::class)
            ->add('Ajouter',      SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($currencie);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info','La devise a été ajoutée');

            }
        }

        $currencies = $em->getRepository('IUTAdminBundle:Currencies')->findAll();
        return $this->render('IUTAdminBundle:Default:addCurrencies.html.twig', array(
            'form' => $form->createView(), 'currencies' => $currencies) );
    }

    public function addCoinsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $coin = new Coins();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $coin);

        $formBuilder
            ->add('value',      TextType::class)
            ->add('currencies',      EntityType::class, array('class' => Currencies::class, 'choice_label' => 'name',  'multiple' => false,
            'expanded' => true,))

            ->add('Ajouter',      SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($coin);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info','La pièce a été ajoutée');

            }
        }

        $coins = $em->getRepository('IUTAdminBundle:Coins')->findAll();
        return $this->render('IUTAdminBundle:Default:addCoins.html.twig', array(
            'form' => $form->createView(), 'listCoins' => $coins) );
    }

}

