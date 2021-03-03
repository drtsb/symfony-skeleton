<?php

declare(strict_types=1);

namespace App\User\Application\User\Command\Edit;

use App\User\Domain\Aggregate\User\UserRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices'  => array_combine(UserRole::VALUES, UserRole::VALUES),
                    'expanded' => true,
                    'multiple' => true,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => EditCommand::class,
            ]
        );
    }
}
