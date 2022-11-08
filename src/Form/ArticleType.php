<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Episode;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class) 
            ->add('url')
            ->add('auteur', ChoiceType::class, [
                'choices' => [
                    'Gaetan' => 'gaetan',
                    'Cédric' => 'cedric',
                    'Public' => 'public'
                ]
            ])
            ->add('category', EntityType::class, 
            [
                'class' => Episode::class,
                'choice_label' => 'title'
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
