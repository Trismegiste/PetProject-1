<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Trismegiste\FrontBundle\Model\Vertex as Model;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BatchInsert is a form for batch insert of vertices
 */
class BatchInsert extends AbstractType
{

    public function getName()
    {
        return "batch_vertex";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $embed = $builder->add('Collection', 'collection', [
            'type' => new Category(),
            'allow_add' => true
        ]);
    }

}