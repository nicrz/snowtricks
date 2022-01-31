<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('idtrick', HiddenType::class, [
            // renders it as a single text box
            'mapped' => false,
        ]);

        //$builder->add('iduser', HiddenType::class, [
            // renders it as a single text box
        //    'mapped' => false,
        //]);
        
        $builder->add(
            'content',
            TextareaType::class,
            [
                "required" => true
            ]
        );

    }


}