<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Model;

use Trismegiste\Yuurei\Persistence\Decorator;
use Trismegiste\Yuurei\Transform\Mediator\Colleague\MapObject;
use Trismegiste\FrontBundle\Utils\Helper;

/**
 * VertexRepo is a repository for vertex
 */
class VertexRepo extends Decorator
{

    public function find(array $query = array(), array $fields = array())
    {
        // forces the type
        $query[MapObject::FQCN_KEY] = __NAMESPACE__ . '\Vertex';

        return parent::find($query, $fields);
    }

    public function findOne(array $query = array(), array $fields = array())
    {
        // forces the type of document
        $query[MapObject::FQCN_KEY] = __NAMESPACE__ . '\Vertex';

        return parent::findOne($query, $fields);
    }

    public function findByGraph($fk, array $fields = [])
    {
        // filters on one graph
        $query['graphId'] = $fk;

        return $this->find($query, $fields);
    }

    public function findSlugInGraph($fk, $slug)
    {
        $query = [
            'slug' => $slug,
            'graphId' => $fk
        ];

        return $this->findOne($query);
    }

    public function getMentionByGraph($fk)
    {
        $cursor = $this->findByGraph($fk, ['title' => true, 'slug' => true]);

        $found = [];
        foreach ($cursor as $doc) {
            $found[] = [
                'username' => Helper::slugToMention($doc['slug']),
                'name' => $doc['title']
            ];
        }

        return $found;
    }

    public function searchTextInGraph($fk, $keyword)
    {
        $regex = new \MongoRegex("/$keyword/i");
        $cursor = $this->find([
            'graphId' => $fk,
            '$or' => [
                ['title' => ['$regex' => $regex]],
                ['description' => ['$regex' => $regex]],
                ['gmOnly' => ['$regex' => $regex]]
            ]
        ]);

        return $cursor;
    }

}