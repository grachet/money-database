<?php

namespace IUT\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IUT\AdminBundle\Entity\Coins;
use IUT\AdminBundle\Entity\Currencies;
use IUT\AdminBundle\Entity\Files;
use IUT\AdminBundle\Entity\Images;
use IUT\AdminBundle\Entity\Users;

class LoadCategory implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter


        $logins = array(
            'admin',
            'guest',
            'guillaume',
            'irvin',
            'Coredus',
            'alexandre',
            'Deprasos',
            'Bleu',
            'P-Alex'
        );


        $passwords = array(
            '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918',
            '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8',
            '8819b516366ee88d4a520e85c95bd51975b7efaa8596b5c01180377df1e1ce8d',
            '56dff608ad5edcf9f999614880ad5e9f10bd0e49f3e21d69f0f0fdef7ce8174f',
            '973aa86033e6234d7212821c6117bfb88d9abd1ab7728c8eb98ac581d27635b6',
            'c3dc538eeb2ab2a2c2fe4050ea09f068473dfa2e6fa0f67bc8bbe64194cb0b4e',
            '0b86a526cfd8c5053d8cefc96be1bbe855062636f4bb77cd32c9e3ff3d623386',
            'deb50bf99ee94f985fc0d3ddec88aeb4a37eb3fef0ae8e9ca85312a8d145c2ac',
            '94426e968955eed45c8a938eee183eb94bd87e040571a7d3e882b5e8b29adf13'
        );

        $descriptions = array(
            'Le compte admin pour avoir les commandes les plus poussées',
            'Le compte guest pour les invités',
            'guillaume description',
            'irvin description',
            'Coredus description',
            'alexandre description',
            'Deprasos description',
            'Bleu description',
            'P-Alex description'
        );


        $names = array(
            'admin',
            'guest',
            'guillaume',
            'irvin',
            'lohan',
            'alexandre',
            'Arman',
            'Romain',
            'Pierre-Alexandre'
        );

        for ($i = 0; $i < count($logins); $i++) {

            $User = new Users();
            $User->setLogin($logins[$i]);
            $User->setDescription($descriptions[$i]);
            $User->setName($names[$i]);
            $User->setPassword($passwords[$i]);


            $file = new Files();
            $file->setName('nom fichier 2');
            $file->setDescription("un bon fichier");
            $file->setUrl("http://exo7.emath.fr/cours/cours-exo7.pdf");
            $file->setUsers($User);


            $file2 = new Files();
            $file2->setName('nom fichier 1');
            $file2->setDescription("un bon fichier");
            $file2->setUrl("http://exo7.emath.fr/cours/cours-exo7.pdf");
            $file2->setUsers($User);



            $manager->persist($User);
            $manager->persist($file);
            $manager->persist($file2);
        }

        $currencies = array(
            'dollar',
            'euro',
            'livre',
            'franc suisse',
            'dinar'
        );

        $coins = array(
            '1',
            '2',
            '5',
            '0.5'
        );


        for ($i = 0; $i < count($currencies); $i++) {

            $currencie = new Currencies();
            $currencie->setName($currencies[$i]);
            $manager->persist($currencie);


            for ($j = 0; $j < count($coins); $j++) {

                $coin = new Coins();
                $coin->setValue($coins[$j]);
                $coin->setCurrencies($currencie);

                $image = new Images();
                $image->setName($coin->getValue());
                $image->setUrl("https://cdn.pixabay.com/photo/2013/07/12/12/14/euro-145386_960_720.png");
                $image->setCoins($coin);



$manager->persist($image);
                $manager->persist($coin);
            }

        }



        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}