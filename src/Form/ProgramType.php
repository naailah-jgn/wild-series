<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'required' => true,
                    'class' =>'form-control',
                    'length' => '255',
                ],
                'label' => 'Nom d\'une série',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('synopsis', TextareaType::class, [
                'attr' => [
                    'required' => true,
                    'class' =>'form-control',
                ],
                'label' => 'Résumé de la série',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('poster', TextType::class, [
                'attr' => [
                    'required' => true,
                    'class' =>'form-control',
                    'length' => '255',
                ],
                'label' => 'Image d\'une série',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('category', null, ['choice_label' => 'name',
            'attr' => [
                'required' => true,
                'class' =>'form-select',
            ],
            'label' => 'Ajout d\'une catégorie',
            'label_attr' => [
                'class' => 'form-label'
            ]])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-secondary'
                ]
            ]);
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
