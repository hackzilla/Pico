<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="domain")
 * @ORM\HasLifecycleCallbacks
 */
class Domain
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=6)
     */
    private $rank;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $domain;

    /**
     * @ORM\Column(name="nextindex", type="datetime", nullable="true")
     */
    private $nextIndex = null;

    /**
     * @ORM\Column(name="lastindex", type="datetime", nullable="true")
     */
    private $lastIndex = null;

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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set domain
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set nextIndex
     *
     * @param datetime $nextIndex
     */
    public function setNextIndex($nextIndex)
    {
        $this->nextIndex = $nextIndex;
    }

    /**
     * Get nextIndex
     *
     * @return datetime 
     */
    public function getNextIndex()
    {
        return $this->nextIndex;
    }

    /**
     * Set lastIndex
     *
     * @param datetime $lastIndex
     */
    public function setLastIndex($lastIndex)
    {
        $this->lastIndex = $lastIndex;
    }

    /**
     * Get lastIndex
     *
     * @return datetime 
     */
    public function getLastIndex()
    {
        return $this->lastIndex;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}