<?php

namespace Ofdan\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="rank")
 * @ORM\HasLifecycleCallbacks
 */
class Rank
{
    /**
     * @ORM\Column(name="domainId", type="integer")
     * @ORM\Id
     */
    private $domainId;

    /**
     * @ORM\Column(name="keyword_id", type="integer")
     * @ORM\Id
     */
    private $keywordId;

    /**
     * @ORM\Column(type="smallinteger")
     */
    private $score;

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