<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Utils;

/**
 * MarkdownExtension is a markdown render extension for twig
 */
class MarkdownExtension extends \Twig_Extension
{

    protected $transformer;

    public function __construct(\Michelf\Markdown $tr)
    {
        $this->transformer = $tr;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', array($this, 'markdownFilter'))
        ];
    }

    public function getName()
    {
        return 'markdown_extension';
    }

    public function markdownFilter($text)
    {
        return $this->transformer->transform($text);
    }

}