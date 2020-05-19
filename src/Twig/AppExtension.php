<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class AppExtension
 *
 * @package App\Twig
 */
class AppExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('in_array', [$this, 'inArray', ['haystack', 'target']])
        ];
    }

    /**
     * Check if at least one of $target is in $haystack
     *
     * @param array $haystack
     * @param array $target
     *
     * @return bool
     */
    public function inArray($haystack, array $target): bool
    {
        return count(array_intersect((array)$haystack, $target)) > 0;
    }
}