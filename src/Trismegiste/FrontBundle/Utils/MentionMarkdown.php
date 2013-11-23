<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Utils;

/**
 * MentionMarkdown is a markdown with mention '@xxxx'
 */
class MentionMarkdown extends \Michelf\Markdown
{

    protected $mention;

    public function __construct()
    {
        $this->mention = [];
        $this->span_gamut['doAnchorMention'] = 19;
        parent::__construct();
    }

    protected function doAnchorMention($text)
    {
        return preg_replace_callback('#(^|\s)@([^\s]+)#', function($matches) {
            print_r($matches);
                    $slug = $matches[2];
                    return " [$slug](/app_dev.php/vertex/show/$slug)";
                }, $text);
    }

}