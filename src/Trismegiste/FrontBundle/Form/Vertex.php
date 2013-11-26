<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vertex is a form for Vertex
 */
class Vertex extends AbstractType
{

    public function getName()
    {
        return "vertex";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('headline', 'text', ['required' => false, 'attr' => ['class' => 'span6']])
                ->add('description', 'textarea', ['attr' => ['class' => 'span6 mentionable', 'rows' => 6]])
                ->add('gmOnly', 'textarea', ['required' => false, 'attr' => ['class' => 'span6 mentionable', 'rows' => 6]])
                ->add('save', 'submit');
    }

    public function getParent()
    {
        return 'minivertex';
    }

}