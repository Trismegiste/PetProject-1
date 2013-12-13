<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Utils;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * InternalMentionLink is a fake url generator for mentions in the markdown twig filter
 * It replaces url to vertex by internal link in the same page, example : 
 * <a href="#slug-to-the-vertex"> instead of <a href="/vertex/slug-to-the-vertex">
 * 
 * The purpose is to generate static html pages
 */
class InternalMentionLink implements UrlGeneratorInterface
{

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if ($name == 'vertex_findbyslug') {
            return '#' . $parameters['slug'];
        }

        return "#404notfound";
    }

    public function getContext()
    {
        
    }

    public function setContext(\Symfony\Component\Routing\RequestContext $context)
    {
        
    }

}