<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', HiddenType::class)
            ->add('password', PasswordType::class , [
                'label' => "Modifier le mot de passe",  
            ])
            ->add('password_confirm', PasswordType::class, [
                'mapped' => false,
                'label' => "Confirmer votre mot de passe",
            ])
            ->add('pseudo', TextType::class, [
                'label' => "Modifier votre pseudo",
            ])
            ->add('avatar', UrlType::class , [
                'label' => 'Url de votre avatar',
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
