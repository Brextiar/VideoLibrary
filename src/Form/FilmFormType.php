<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Film;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FilmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Title : ',
                'row_attr' => [
                    'class' => 'input-group mb-3'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description : ',
                'row_attr' => [
                    'class' => 'input-group mb-3'
                ]
            ])
//            ->add('creatingDate', null, [
//                'widget' => 'single_text',
//            ])
            ->add('poster', FileType::class, [
                'label' => 'Affiche au format : .jpeg, .jpg, .png',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'maxSizeMessage' => 'Ce fichier est trop lourd',
                        'mimeTypesMessage' => 'Le format est pas ok: (.jpeg, .jpg, .png)',
                    ]),
                ],
                'row_attr' => [
                    'class' => 'input-group mb-3'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => '--Veuillez choisir une catégorie--',
                'row_attr' => [
                    'class' => 'input-group mb-3'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-dark mt-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
