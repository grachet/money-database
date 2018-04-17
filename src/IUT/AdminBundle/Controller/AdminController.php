<?php

namespace IUT\AdminBundle\Controller;

use IUT\AdminBundle\Entity\Coins;
use IUT\AdminBundle\Entity\Files;
use IUT\AdminBundle\Entity\Currencies;
use IUT\AdminBundle\Entity\Images;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\BrowserKit\Response;

class AdminController extends Controller
{
    public function homeAction()
    {

        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('IUTAdminBundle:Users')->findBy(array('username' => 'admin'));
        $file = $em->getRepository('IUTAdminBundle:Files')->findBy(array('Users' => $admin));

        $nbCoins = count($em->getRepository('IUTAdminBundle:Coins')->findAll());
        $nbFiles = count($em->getRepository('IUTAdminBundle:Files')->findAll());
        $nbImages = count($em->getRepository('IUTAdminBundle:Images')->findAll());
        $nbCurrencies = count($em->getRepository('IUTAdminBundle:Currencies')->findAll());

        return $this->render('IUTAdminBundle:Default:home.html.twig', array('listFiles' => $file, 'nbCoins' => $nbCoins, 'nbFiles' => $nbFiles, 'nbImages' => $nbImages, 'nbCurrencies' => $nbCurrencies));
    }


    public function modProfilAction(Request $request)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();


        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        $formBuilder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('imageFile', FileType::class)
            ->add('email', TextType::class)
            ->add('Enregistrer', SubmitType::class);

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

                $request->getSession()->getFlashBag()->add('info', 'Le profil a été modifié');

            }
        }


        return $this->render('IUTAdminBundle:Default:modProfil.html.twig', array(
            'form' => $form->createView(), 'user' => $user));
    }

    public function tabUsersAction()
    {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('IUTAdminBundle:Users')->findAll();


        return $this->render('IUTAdminBundle:Default:tabUsers.html.twig', array('listUsers' => $users));

    }

    public function tabImagesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('IUTAdminBundle:Images')->findAll();


        return $this->render('IUTAdminBundle:Default:tabImages.html.twig', array('listImages' => $images));

    }

    public function tabFilesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('IUTAdminBundle:Files')->findAll();


        return $this->render('IUTAdminBundle:Default:tabFiles.html.twig', array('listFiles' => $files));

    }

    public function tabCoinsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $coins = $em->getRepository('IUTAdminBundle:Coins')->findAll();


        return $this->render('IUTAdminBundle:Default:tabCoins.html.twig', array('listCoins' => $coins));

    }

    public function tabCurrenciesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $currencies = $em->getRepository('IUTAdminBundle:Currencies')->findAll();


        return $this->render('IUTAdminBundle:Default:tabCurrencies.html.twig', array('listCurrencies' => $currencies));

    }


    public function addCurrenciesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        $currencie = new Currencies();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $currencie);

        $formBuilder
            ->add('name', TextType::class)
            ->add('Ajouter', SubmitType::class);

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($currencie);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info', 'La devise a été ajoutée');

            }
        }

        $currencies = $em->getRepository('IUTAdminBundle:Currencies')->findAll();
        return $this->render('IUTAdminBundle:Default:addCurrencies.html.twig', array(
            'form' => $form->createView(), 'currencies' => $currencies));
    }

    public function addCoinsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $coin = new Coins();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $coin);

        $formBuilder
            ->add('value', TextType::class)
            ->add('currencies', EntityType::class, array('class' => Currencies::class, 'choice_label' => function ($currencies) {
                /** @var Currencies $currencies */
                return strtoupper($currencies->getName()) . "                ";
            }, 'multiple' => false,
                'expanded' => true,))
            ->add('Ajouter', SubmitType::class);

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($coin);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info', 'La pièce a été ajoutée');

            }
        }

        $coins = $em->getRepository('IUTAdminBundle:Coins')->findAll();
        return $this->render('IUTAdminBundle:Default:addCoins.html.twig', array(
            'form' => $form->createView(), 'listCoins' => $coins));
    }

    public function deleteAction($id, $classe)
    {


        $em = $this->getDoctrine()->getManager();

        If ($classe == 'ImagesSelected') {
            $object = $em->getRepository("IUTAdminBundle:Images")->find($id);
            $em->remove($object);
            $em->flush();
            return $this->redirectToRoute('iut_admin_selectedViewImages');
        }


        $object = $em->getRepository("IUTAdminBundle:$classe")->find($id);


        $em->remove($object);
        $em->flush();

        If ($classe == 'Currencies') {
            return $this->redirectToRoute('iut_admin_addCurrencies');
        }

        If ($classe == 'Coins') {
            return $this->redirectToRoute('iut_admin_addCoins');
        }

        If ($classe == 'Images') {
            return $this->redirectToRoute('iut_admin_viewImages');
        }

        If ($classe == 'Files') {
            return $this->redirectToRoute('iut_admin_addFile');
        }
    }


    public
    function viewImagesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Images = $em->getRepository("IUTAdminBundle:Images")->findAll();

        return $this->render('IUTAdminBundle:Default:viewImages.html.twig', array('listImages' => $Images));

    }

    public
    function downloadImagesAction()
    {


        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository("IUTAdminBundle:Images")->findAll();

        $files = array();

        foreach ($images as $image) {
            array_push($files, "../web/uploads/images/".$image->getImage());
        }

        $zip = new \ZipArchive();
        $zipName = 'Images_'.time().".zip";
        $zip->open($zipName,  \ZipArchive::CREATE);

        foreach ($files as $f) {
            $zip->addFromString(basename($f),  file_get_contents($f));
        }
        $zip->close();

        return $this->file($zipName);


    }


    public function addFileAction(Request $request)
    {
        $user = $this->getUser();
        $id = $user->getID();

        $em = $this->getDoctrine()->getManager();
        $file = new Files();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $file);

        $formBuilder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('file', FileType::class)
            ->add('Ajouter', SubmitType::class);

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $file->setUsers($user);
                $em->persist($file);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info', 'Le fichier a été ajouté');

            }
        }

        $files = $em->getRepository('IUTAdminBundle:Files')->findBy(array('Users' => $id));
        return $this->render('IUTAdminBundle:Default:addFile.html.twig', array(
            'form' => $form->createView(), 'listFiles' => $files));
    }


    public function addImageAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $image = new Images();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $image);

        $formBuilder
            ->add('name', TextType::class)
            ->add('coins', EntityType::class, array('class' => Coins::class, 'choice_label' => function ($coins) {
                /** @var Coins $coins */
                return strtoupper($coins->getValue()) . " " . strtoupper($coins->getCurrencies()->getName()) . "                ";
            }, 'multiple' => true,
                'expanded' => true,))
            ->add('imageFile', FileType::class)
            ->add('Ajouter', SubmitType::class);

        $form = $formBuilder->getForm();

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();

                $request->getSession()->getFlashBag()->add('info', "L'image a été ajoutée");

            }
        }

        return $this->render('IUTAdminBundle:Default:addImage.html.twig', array(
            'form' => $form->createView()));
    }

    public
    function selectedViewImagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Images = array();

        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('value', TextType::class)
            ->add('currencie', TextType::class)
            ->getForm();


        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $value = $data['value'];
                $currencie = $data['currencie'];

                $currencies = $em->getRepository("IUTAdminBundle:Currencies")->findOneBy(array('name' => $currencie));
                $coins = $em->getRepository("IUTAdminBundle:Coins")->findBy(array('value' => $value, 'Currencies' => $currencies));


                if ($coins != null) {

                    foreach ($coins as $coin) {
                        $listImage = $coin->getImages();

                        foreach ($listImage as $image) {


                            if (!in_array($image, $Images)) {
                                array_push($Images, $image);
                            }


                        }

                    }


                }


            }
        }


        return $this->render('IUTAdminBundle:Default:selectedViewImages.html.twig', array('form' => $form->createView(), 'listImages' => $Images));

    }


}

