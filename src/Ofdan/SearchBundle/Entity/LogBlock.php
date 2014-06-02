<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ofdan\SearchBundle\Repository\LogBlockRepository")
 * @ORM\Table(name="logBlock")
 * @ORM\HasLifecycleCallbacks
 */
class LogBlock
{

    /**
     * @ORM\ManyToOne(targetEntity="Domain")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $reason;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $info;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updatedAt;

    const REASON_NONE = 10;
    const REASON_ROBOT = 11;
    const REASON_KEYWORD = 12;
    const REASON_DESCRIPTION = 13;
    const REASON_CONTENT = 14;
    const REASON_CONNECTION = 15;
    const REASON_META = 16;

    static public $types = array(
        self::REASON_NONE => 'none',
        self::REASON_ROBOT => 'robot',
        self::REASON_KEYWORD => 'keyword',
        self::REASON_DESCRIPTION => 'description',
        self::REASON_CONTENT => 'content',
        self::REASON_CONNECTION => 'connection',
        self::REASON_META => 'meta',
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
     * Set reason
     *
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set info
     *
     * @param text $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * Get info
     *
     * @return text 
     */
    public function getInfo()
    {
        return $this->info;
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

}
