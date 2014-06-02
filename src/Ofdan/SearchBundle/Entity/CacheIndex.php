<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ofdan\SearchBundle\Repository\CacheIndexRepository")
 * @ORM\Table(name="cacheIndex")
 * @ORM\HasLifecycleCallbacks
 */
class CacheIndex
{

    /**
     * @ORM\OneToOne(targetEntity="Domain", inversedBy="index")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="`index`", type="text")
     */
    private $index;

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
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set domainId
     *
     * @param integer $domainId
     */
    public function setDomainId($domainId)
    {
        $this->domainId = $domainId;
    }

    /**
     * Get domainId
     *
     * @return integer 
     */
    public function getDomainId()
    {
        return $this->domainId;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set index
     *
     * @param text $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * Get index
     *
     * @return text 
     */
    public function getIndex()
    {
        return $this->index;
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

    /**
     * Set domain
     *
     * @param Ofdan\SearchBundle\Entity\Domain $domain
     */
    public function setDomain(\Ofdan\SearchBundle\Entity\Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain
     *
     * @return Ofdan\SearchBundle\Entity\Domain 
     */
    public function getDomain()
    {
        return $this->domain;
    }

}
