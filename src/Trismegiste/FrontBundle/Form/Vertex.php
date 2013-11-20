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
 * Vertex is a form for Vertex
 */
class Vertex extends AbstractType
{

    protected $choiceType;

    public function __construct(array $typeList)
    {
        $this->choiceType = $typeList;
    }

    public function getName()
    {
        return "vertex";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('infoType', 'choice', [
                    'choices' => $this->choiceType,
                    'expanded' => false,
                    'multiple' => false,
                    'disabled' => false
                ])
                ->add('title', 'text', ['constraints' => new Assert\NotBlank(), 'required' => true])
                ->add('headline', 'text', ['required' => false])
                ->add('description', 'textarea')
                ->add('gmOnly', 'textarea', ['required' => false])
                ->add('submit', 'submit')
                ->setDataMapper(new PropertyPathMapper(new PropertyAccessor(true)))
                ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                            $data = $event->getData();
                            $form = $event->getForm();
                            //       if (!is_null($data) && !is_null())
                            //      var_dump($form['infoType']->getConfig());
                        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $emptyData = function (Options $options) {
                    return function (FormInterface $form) {
                                return $form->isEmpty() && !$form->isRequired() ? null : new Model('a');
                            };
                };

        $resolver->setDefaults(array(
            'empty_data' => $emptyData,
            'data_class' => 'Trismegiste\FrontBundle\Model\Vertex'
        ));
    }

}