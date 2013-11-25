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
 * MiniVertex is a minimal form for Vertex
 */
class MiniVertex extends AbstractType
{

    public function getName()
    {
        return "minivertex";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('infoType', new Category())
                ->add('title', 'text', ['constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 3])
                    ],
                    'required' => true
                ])
                ->setDataMapper(new PropertyPathMapper(new PropertyAccessor(true)))
                ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                            $data = $event->getData();
                            $form = $event->getForm();
                            if (!is_null($data) && !is_null($data->getId())) {
                                unset($form['infoType']);
                            }
                        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $emptyData = function (Options $options) {
                    return function (FormInterface $form) {
                                return $form->isEmpty() && !$form->isRequired() ? null : new Model('undefined');
                            };
                };

        $resolver->setDefaults(array(
            'empty_data' => $emptyData,
            'data_class' => 'Trismegiste\FrontBundle\Model\Vertex'
        ));
    }

}