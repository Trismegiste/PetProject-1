<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Utils;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * MentionMarkdown is a markdown with mention '@slug' for vertex
 */
class MentionMarkdown extends \Michelf\Markdown
{

    protected $urlGenerator;
    protected $baseRoute;

    public function __construct(UrlGeneratorInterface $gene, $baseroute)
    {
        $this->urlGenerator = $gene;
        $this->baseRoute = $baseroute;
        $this->span_gamut['doAnchorMention'] = 19;
        parent::__construct();
    }

    protected function doAnchorMention($text)
    {
        $generator = $this->urlGenerator;
        $route = $this->baseRoute;
        return preg_replace_callback('#(^|\s)@([^\s]+)#', function($matches) use ($generator, $route) {
                    $slug = $matches[2];
                    $moreReadable = str_replace('-', ' ', $slug);
                    $url = $generator->generate($route, ['slug' => $slug]);
                    return " [$moreReadable]($url)";
                }, $text);
    }

}