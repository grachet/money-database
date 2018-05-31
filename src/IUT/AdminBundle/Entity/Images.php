<?php

namespace IUT\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Images
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="IUT\AdminBundle\Repository\ImagesRepository")
 * @Vich\Uploadable
 */
class Images
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
     * @ORM\ManyToMany(targetEntity="IUT\AdminBundle\Entity\Coins", inversedBy="Images")
     * @ORM\JoinTable(name="images_coins")
     */
    private $Coins;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    public function __construct() {
        $this->Coins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime('now');
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
     * @return Images
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
     * Set coins
     *
     * @param \IUT\AdminBundle\Entity\Coins $coins
     *
     * @return Images
     */
    public function setCoins(\IUT\AdminBundle\Entity\Coins $coins)
    {
        $this->Coins = $coins;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->createdAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Add coin
     *
     * @param \IUT\AdminBundle\Entity\Coins $coin
     *
     * @return Images
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
     * Set image
     *
     * @param string $image
     *
     * @return Images
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Images
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
