<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Model;

use Trismegiste\Yuurei\Persistence\Decorator;
use Trismegiste\Yuurei\Transform\Mediator\Colleague\MapObject;

/**
 * VertexRepo is a repository for vertex
 */
class VertexRepo extends Decorator
{

    public function find(array $query = array(), array $fields = array())
    {
        $query[MapObject::FQCN_KEY] = __NAMESPACE__ . '\Vertex';
        return parent::find($query, $fields);
    }

}