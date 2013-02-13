<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ofdan\SearchBundle\Repository\DomainRepository")
 * @ORM\Table(name="domain")
 * @ORM\Table(name="domain", indexes={
 *     @ORM\Index(name="domain_status_idx", columns={"status"})
 * })
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
    private $rank = 0;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     */
    private $status = self::STATUS_QUEUE;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     * @Assert\NotBlank
     */
    private $domain;

    /**
     * @ORM\Column(name="nextindex", type="datetime", nullable=true)
     */
    private $nextIndex = null;

    /**
     * @ORM\Column(name="lastindex", type="datetime", nullable=true)
     */
    private $lastIndex = null;

    /**
     * @ORM\OneToOne(targetEntity="Metadata",mappedBy="domain")
     */
    public $metadata;

    /**
     * @ORM\OneToOne(targetEntity="CacheHeader",mappedBy="domain")
     */
    public $header;

    /**
     * @ORM\OneToOne(targetEntity="CacheIndex",mappedBy="domain")
     */
    public $index;

    /**
     * @ORM\OneToOne(targetEntity="CacheRobot",mappedBy="domain")
     */
    public $robot;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updatedAt;

    
    const STATUS_QUEUE = 10;
    const STATUS_PROCESSING = 11;
    const STATUS_STORED = 12;
    const STATUS_PAUSED = 13;
    const STATUS_BLOCKED = 14;
    const STATUS_USELESS = 15;

    static public $statuses = array(
        self::STATUS_QUEUE => 'queue',
        self::STATUS_PROCESSING => 'processing',
        self::STATUS_STORED => 'stored',
        self::STATUS_PAUSED => 'paused',
        self::STATUS_BLOCKED => 'blocked',
        self::STATUS_USELESS => 'useless',
    );

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
     * @param smallint $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set status string
     *
     * @param string $status
     */
    public function setStatusString($status)
    {
        $this->status = in_array(self::$status, $this->status);
    }
    /**
     * Get status
     *
     * @return smallint 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get status string
     *
     * @return string 
     */
    public function getStatusString()
    {
        return self::$status[$this->status];
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

    /**
     * Get header
     *
     * @return Ofdan\SearchBundle\Entity\CacheHeader
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Get index
     *
     * @return Ofdan\SearchBundle\Entity\CacheIndex
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Get robot
     *
     * @return Ofdan\SearchBundle\Entity\CacheRobot
     */
    public function getRobot()
    {
        return $this->robot;
    }
}