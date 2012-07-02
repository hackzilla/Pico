<?php

namespace Ofdan\SearchBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class AddSiteModel
{
    /**
     * @var string
     * @Assert\Regex(pattern="/^([a-z0-9-]+\.)+[a-z]{2,6}$/", message="Please enter a valid lowercase domain name")
     */
    public $domain;

    /**
     * @var string
     */
    public $captcha;
}