<?php

namespace App\Forms;

use App\Entity\Trick;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('main_image', FileType::class, [

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '10M',
                ])
            ],
        ]);
        
        $builder->add(
            'name',
            TextType::class,
            [
                "required" => true
            ]
        );

        $builder->add(
            'description',
            TextareaType::class,
            [
                "required" => true
            ]
        );

        $builder->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'name'
        ]);

        $builder->add('author', HiddenType::class, [
            // renders it as a single text box
            'mapped' => false,
        ]);

    }


}