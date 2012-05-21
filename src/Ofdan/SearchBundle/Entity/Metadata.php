<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="metadata")
 * @ORM\HasLifecycleCallbacks
 */
class Metadata
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $domainId;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $dialect;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $extract;

    /**
     * @ORM\Column(type="datetime")
     */
    private $thumbCreated;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }


    /**
     * @ORM\preUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}