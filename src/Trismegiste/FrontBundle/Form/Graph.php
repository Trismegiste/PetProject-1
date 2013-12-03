<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Trismegiste\FrontBundle\Model\Vertex as Model;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * Graph is a form for graph
 */
class Graph extends AbstractType
{

    public function getName()
    {
        return "graph";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', ['constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 3])
                    ],
                    'required' => true
                ])
                ->add('save', 'submit')
                ->setDataMapper(new PropertyPathMapper(new PropertyAccessor(true)));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Trismegiste\FrontBundle\Model\Graph'
        ));
    }

}