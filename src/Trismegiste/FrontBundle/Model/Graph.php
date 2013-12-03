<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Model;

use Trismegiste\Yuurei\Persistence\Persistable;

/**
 * Graph is a set of vertices
 */
class Graph implements Persistable
{

    use \Trismegiste\Magic\Proto\AnemicModel\GetterSetter,
        \Trismegiste\Yuurei\Persistence\PersistableImpl;

    protected $title;

}