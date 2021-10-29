<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @SuppressWarnings(PMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'user_form_label_username',
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'user_form_label_lastname',
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'user_form_label_name',
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'user_form_label_email',
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Repeat password must be same as actual password',
                    'first_options' => ['label' => 'user_form_label_password', 'error_bubbling' => true],
                    'second_options' => ['label' => 'user_form_label_repeat_password'],
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => [
                        'user_form_label_role_admin' => User::ROLE_ADMIN,
                        'user_form_label_role_employee' => User::ROLE_DEFAULT,
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'user_form_label_roles',
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User',
            'validation_groups' => function (FormInterface $form) {
                /** @var User $data */
                $data = $form->getData();
                $groups = ['Default'];
                if (!$data->getId()) {
                    $groups[] = 'create';
                }

                return $groups;
            },
            'translation_domain' => 'user',
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
