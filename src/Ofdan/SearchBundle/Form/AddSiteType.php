<?php

namespace Ofdan\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddSiteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('domain', 'text');
        $builder->add('captcha', 'captcha');
    }

    public function getName()
    {
        return 'addSite';
    }

}
