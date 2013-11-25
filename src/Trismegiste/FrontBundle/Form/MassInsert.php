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
 * MassInsert is a form for mass insert of vertices
 */
class MassInsert extends AbstractType
{

    protected $choiceType;

    public function __construct()
    {
        $typeList = ['area', 'npc', 'item'];
        $this->choiceType = array_combine($typeList, $typeList);
    }

    public function getName()
    {
        return "mass_vertex";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $embed = $builder->add('Collection', 'collection', [
            'type' => $builder->add('infoType', 'choice', [
                        'choices' => $this->choiceType,
                        'expanded' => true,
                        'multiple' => false,
                        'constraints' => new Assert\NotBlank()
                    ])
                    ->add('title', 'text', ['constraints' => [
                            new Assert\NotBlank(),
                            new Assert\Length(['min' => 3])
                        ],
                        'required' => true
                    ]),
            'allow_add' => true
                ]
        );
    }

}