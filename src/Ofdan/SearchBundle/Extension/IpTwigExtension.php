<?php

namespace Ofdan\SearchBundle\Extension;

class IpTwigExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            'mask' => new \Twig_Filter_Method($this, 'mask'),
            'gethostbyaddr' => new \Twig_Filter_Function('gethostbyaddr'),
        );
    }

    public function mask($sentence)
    {

        $bits = \explode('.', $sentence);
        $lastElement = \count($bits) - 1;

        if ($lastElement > 2) {
            if (\is_numeric($bits[$lastElement]) && $lastElement == 3) {
                // IP
                $sentence = $bits[0] . '.' . $bits[1] . '.x.x';
            } else if (\strlen($bits[$lastElement]) == 2) {
                //
                $sentence = "{$bits[$lastElement - 2]}.{$bits[$lastElement - 1]}.{$bits[$lastElement]}";
            } else {
                $sentence = "{$bits[$lastElement - 1]}.{$bits[$lastElement]}";
            }
        }

        return $sentence;
    }

    public function getName()
    {
        return 'ip_twig_extension';
    }

}
