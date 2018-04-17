<?php

namespace IUT\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Currencies
 *
 * @ORM\Table(name="currencies")
 * @ORM\Entity(repositoryClass="IUT\AdminBundle\Repository\CurrenciesRepository")
 */
class Currencies
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80, unique=true)
     */
    private $name;


    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Coins", mappedBy="Currencies", cascade={"remove"})
     */
    private $Coins;


    public function __construct() {
        $this->Coins = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Currencies
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * Add coin
     *
     * @param \IUT\AdminBundle\Entity\Coins $coin
     *
     * @return Currencies
     */
    public function addCoin(\IUT\AdminBundle\Entity\Coins $coin)
    {
        $this->Coins[] = $coin;

        return $this;
    }

    /**
     * Remove coin
     *
     * @param \IUT\AdminBundle\Entity\Coins $coin
     */
    public function removeCoin(\IUT\AdminBundle\Entity\Coins $coin)
    {
        $this->Coins->removeElement($coin);
    }

    /**
     * Get coins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoins()
    {
        return $this->Coins;
    }
}
