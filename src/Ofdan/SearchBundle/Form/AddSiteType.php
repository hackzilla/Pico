<?php

namespace Ofdan\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddSiteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('domain', 'text');
        $builder->add('captcha', 'captcha');
    }

    public function getName()
    {
        return 'addSite';
    }
}