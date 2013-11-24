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

    public function __construct()
    {
        $typeList = ['area', 'npc', 'item'];
        $this->choiceType = array_combine($typeList, $typeList);
    }

    public function getName()
    {
        return "vertex";
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('infoType', 'choice', [
                    'choices' => $this->choiceType,
                    'expanded' => true,
                    'multiple' => false,
                    'constraints' => new Assert\NotBlank()
                ])
                ->add('title', 'text', ['constraints' => new Assert\NotBlank(), 'required' => true])
                ->add('headline', 'text', ['required' => false, 'attr' => ['class' => 'span6']])
                ->add('description', 'textarea', ['attr' => ['class' => 'span6 mentionable', 'rows' => 6]])
                ->add('gmOnly', 'textarea', ['required' => false, 'attr' => ['class' => 'span6 mentionable', 'rows' => 6]])
                ->add('save', 'submit')
                ->add('delete', 'submit', ['attr' => ['class' => 'btn btn-danger']])
                ->setDataMapper(new PropertyPathMapper(new PropertyAccessor(true)))
                ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                            $data = $event->getData();
                            $form = $event->getForm();
                            if (!is_null($data) && !is_null($data->getId())) {
                                unset($form['infoType']);
                            } else {
                                unset($form['delete']);
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