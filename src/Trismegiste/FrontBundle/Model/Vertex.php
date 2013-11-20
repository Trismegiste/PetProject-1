<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Model;

use Trismegiste\DokudokiBundle\Persistence\Persistable;

/**
 * Vertex is a node of rpg
 */
class Vertex implements Persistable
{

    use \Trismegiste\Magic\Proto\AnemicModel\GetterSetter;

    protected $id;
    protected $infoType;
    protected $title;
    protected $headline;
    protected $description;
    protected $gmOnly;

    public function __construct($str)
    {
        $this->title = $str;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(\MongoId $pk)
    {
        $this->id = $pk;
    }

}