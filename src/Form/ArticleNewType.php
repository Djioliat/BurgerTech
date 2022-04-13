<?php

namespace App\Form;

use App\Entity\Episode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class,[
        'label' => 'Titre',
        ])
        ->add('introduction', TextType::class,[
        'label' => 'Introduction',
        ])
        ->add('content', TextareaType::class,[
        'label' => 'Contenu'
        ])
        ->add('coverImage', UrlType::class,[
        'label' => 'Url de l\'image'
        ])
        ->add('Audio', UrlType::class,[
        'label' => 'Url de l\'enregistrement'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        'data_class' => Episode::class,
        ]);
    }
}
