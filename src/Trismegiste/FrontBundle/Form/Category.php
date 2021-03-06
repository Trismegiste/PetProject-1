<?php

/*
 * GraphRpg
 */

namespace Trismegiste\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category is a category of vertex form field
 */
class Category extends AbstractType
{

    protected $choiceType;

    public function __construct(array $typeList)
    {
        $this->choiceType = $typeList;
    }

    public function getParent()
    {
        return "choice";
    }

    public function getName()
    {
        return "vertex_category";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->choiceType,
            'expanded' => true,
            'multiple' => false,
            'constraints' => new Assert\NotBlank()
        ]);
    }

}