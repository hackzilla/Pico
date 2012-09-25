<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ofdan\SearchBundle\Repository\CacheRobotRepository")
 * @ORM\Table(name="cacheRobot")
 * @ORM\HasLifecycleCallbacks
 */
class CacheRobot
{
    /**
     * @ORM\OneToOne(targetEntity="Domain", inversedBy="robot")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $robot;

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
     * Set robot
     *
     * @param text $robot
     */
    public function setRobot($robot)
    {
        $this->robot = $robot;
    }

    /**
     * Get robot
     *
     * @return text 
     */
    public function getRobot()
    {
        return $this->robot;
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