<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Model;

use Trismegiste\Yuurei\Persistence\Persistable;

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

    public function __construct($str)
    {
        $this->title = $str;
    }

}