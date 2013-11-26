<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
        $builder->add('batch', 'collection', [
                    'type' => 'minivertex',
                    'allow_add' => true,
                    'label' => false,
                    'options' => ['label_attr' => ['class' => 'hide']]
                ])
                ->add('Save', 'submit');
    }

}