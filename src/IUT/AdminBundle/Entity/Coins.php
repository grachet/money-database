<?php

namespace IUT\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coins
 *
 * @ORM\Table(name="coins")
 * @ORM\Entity(repositoryClass="IUT\AdminBundle\Repository\CoinsRepository")
 */
class Coins
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
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="IUT\AdminBundle\Entity\Currencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Currencies;


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
     * Set value
     *
     * @param float $value
     *
     * @return Coins
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set currencies
     *
     * @param \IUT\AdminBundle\Entity\Currencies $currencies
     *
     * @return Coins
     */
    public function setCurrencies(\IUT\AdminBundle\Entity\Currencies $currencies)
    {
        $this->Currencies = $currencies;

        return $this;
    }

    /**
     * Get currencies
     *
     * @return \IUT\AdminBundle\Entity\Currencies
     */
    public function getCurrencies()
    {
        return $this->Currencies;
    }
}
