<?php

declare(strict_types=1);

namespace App\Task\Presentation\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CreateTaskType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add(
                'title',
                TextType::class,
            )
            ->add(
                'nextAction',
                TextType::class,
            );
    }
}
