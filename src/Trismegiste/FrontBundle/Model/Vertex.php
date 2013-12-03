<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Model;

use Trismegiste\Yuurei\Persistence\Persistable;
use Trismegiste\FrontBundle\Utils\Helper;

/**
 * Vertex is a node of rpg
 */
class Vertex implements Persistable
{

    use \Trismegiste\Magic\Proto\AnemicModel\GetterSetter,
        \Trismegiste\Yuurei\Persistence\PersistableImpl;

    protected $infoType;
    protected $title;
    protected $headline;
    protected $description;
    protected $gmOnly;
    protected $slug;
    protected $graphId;

    public function __construct($str)
    {
        $this->infoType = $str;
    }

    public function setTitle($str)
    {
        $this->title = $str;
        $this->slug = Helper::slugify($str);
    }

}