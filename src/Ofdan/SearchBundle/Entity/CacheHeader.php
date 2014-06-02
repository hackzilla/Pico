<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ofdan\SearchBundle\Repository\CacheHeaderRepository")
 * @ORM\Table(name="cacheHeader")
 * @ORM\HasLifecycleCallbacks
 */
class CacheHeader
{

    /**
     * @ORM\OneToOne(targetEntity="Domain", inversedBy="header")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @Assert\NotBlank
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $header;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updatedAt;

    const TYPE_INDEX = 10;
    const TYPE_ROBOT = 11;

    static public $types = array(
        self::TYPE_INDEX => 'index',
        self::TYPE_ROBOT => 'robot'
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
     * Set type
     *
     * @param smallint $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set type string
     *
     * @param string $type
     */
    public function setTypeString($type)
    {
        $this->type = in_array(self::$type, $this->type);
    }

    /**
     * Get type
     *
     * @return smallint 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get type string
     *
     * @return string 
     */
    public function getTypeString()
    {
        return self::$type[$this->type];
    }

    /**
     * Set domain
     *
     * @param object $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain
     *
     * @return object 
     */
    public function getDomain()
    {
        return $this->domain;
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
     * Set page
     *
     * @param string $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return string 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set header
     *
     * @param text $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * Get header
     *
     * @return text 
     */
    public function getHeader()
    {
        return $this->header;
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
