<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="logBlock")
 * @ORM\HasLifecycleCallbacks
 */
class LogBlock
{
    /**
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="domains")
     * @ORM\JoinColumn(name="domainId", referencedColumnName="id")
     * @ORM\Id
     */
    private $domainId;

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


    const REASON_NONE        = 10;
    const REASON_ROBOT       = 11;
    const REASON_KEYWORD     = 12;
    const REASON_DESCRIPTION = 13;
    const REASON_CONTENT     = 14;
    const REASON_CONNECTION  = 15;
    const REASON_META        = 16;

    static public $types = array(
        self::REASON_NONE        => 'none',
        self::REASON_ROBOT       => 'robot',
        self::REASON_KEYWORD     => 'keyword',
        self::REASON_DESCRIPTION => 'description',
        self::REASON_CONTENT     => 'content',
        self::REASON_CONNECTION  => 'connection',
        self::REASON_META        => 'meta',
    );

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