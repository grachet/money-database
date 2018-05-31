<?php

namespace IUT\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IUT\AdminBundle\Entity\Coins;
use IUT\AdminBundle\Entity\Currencies;
use IUT\AdminBundle\Entity\Files;
use IUT\AdminBundle\Entity\Images;
use IUT\AdminBundle\Entity\Users;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCategory implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;


    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $names = array(
            'admin',
            'guest',
            'guillaume',
            'irvin',
            'loann',
            'alexandre',
            'sebastien',
            'arman',
            'romain',
            'pierre-alexandre'
        );

        $userManager = $this->container->get('fos_user.user_manager');

        for ($i = 0; $i < count($names); $i++) {

            $user = $userManager->createUser();
            $user->setUsername($names[$i]);
            $user->setEmail($names[$i]);
            $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
            // this method will encrypt the password with the default settings :)
            $user->setPlainPassword($names[$i]);
            $userManager->updateUser($user);

        }

    }
}