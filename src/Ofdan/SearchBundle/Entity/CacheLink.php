<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ofdan\SearchBundle\Repository\CacheLinkRepository")
 * @ORM\Table(name="cacheLinks")
 * @ORM\HasLifecycleCallbacks
 */
class CacheLink
{

    /**
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domain;

    /**
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumn(name="linkDomainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $linkDomain;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     */
    private $rank;

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
     * Set linkDomainId
     *
     * @param integer $linkDomainId
     */
    public function setLinkDomainId($linkDomainId)
    {
        $this->linkDomainId = $linkDomainId;
    }

    /**
     * Get linkDomainId
     *
     * @return integer 
     */
    public function getLinkDomainId()
    {
        return $this->linkDomainId;
    }

    /**
     * Set rank
     *
     * @param smallint $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return smallint 
     */
    public function getRank()
    {
        return $this->rank;
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

    /**
     * Set linkDomain
     *
     * @param Ofdan\SearchBundle\Entity\Domain $linkDomain
     */
    public function setLinkDomain(\Ofdan\SearchBundle\Entity\Domain $linkDomain)
    {
        $this->linkDomain = $linkDomain;
    }

    /**
     * Get linkDomain
     *
     * @return Ofdan\SearchBundle\Entity\Domain 
     */
    public function getLinkDomain()
    {
        return $this->linkDomain;
    }

}
