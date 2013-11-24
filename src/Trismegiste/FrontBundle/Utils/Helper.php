<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Utils;

/**
 * Helper is a set of global functions
 */
class Helper
{

    /**
     * Transforms a utf-8 string into a slug
     * 
     * @param string $str
     * 
     * @return string
     */
    static public function slugify($str)
    {
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', str_replace([' ', '_'], '-', $str));

        return preg_replace('#[^-\w]#', '', $str);
    }

}