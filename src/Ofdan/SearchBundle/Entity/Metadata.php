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
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="domains")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domain;

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

    /**
     * Set lang
     *
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set dialect
     *
     * @param string $dialect
     */
    public function setDialect($dialect)
    {
        $this->dialect = $dialect;
    }

    /**
     * Get dialect
     *
     * @return string 
     */
    public function getDialect()
    {
        return $this->dialect;
    }

    /**
     * Set extract
     *
     * @param text $extract
     */
    public function setExtract($extract)
    {
        $this->extract = $extract;
    }

    /**
     * Get extract
     *
     * @return text 
     */
    public function getExtract()
    {
        return $this->extract;
    }

    /**
     * Set thumbCreated
     *
     * @param datetime $thumbCreated
     */
    public function setThumbCreated($thumbCreated)
    {
        $this->thumbCreated = $thumbCreated;
    }

    /**
     * Get thumbCreated
     *
     * @return datetime 
     */
    public function getThumbCreated()
    {
        return $this->thumbCreated;
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