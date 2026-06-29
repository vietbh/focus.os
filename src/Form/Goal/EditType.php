<?php

namespace App\Form\Goal;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Title',
                    'attr' => [
                        'class' => 'block w-full rounded-xl border border-slate-300 bg-white dark:bg-slate-800 px-4 py-3 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200',
                        'placeholder' => 'What do you want to achieve?',
                    ],
                    'label_attr' => [
                        'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                    ],
                    'help' => 'A concise outcome you want to achieve.',
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'required' => true
                ],

            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description',
                    'required' => false,
                    'attr' => [
                        'rows' => 4,
                        'class' => 'block w-full rounded-xl border border-slate-300 bg-white dark:bg-slate-800 px-4 py-3 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200',
                        'placeholder' => 'Describe your goal...',
                    ],
                    'label_attr' => [
                        'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                    ],
                    'help' => 'Optional context, motivation, or success criteria.',
                ],
            )
            ->add(
                'targetDate',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => false,
                    'label' => 'Target Date',
                    'input'  => 'datetime_immutable',
                    'format' => 'dd/MM/yyyy',
                    'html5' => false,
                    'attr' => [
                        'data-controller' => 'flatpickr',
                        'placeholder' => 'Select target date',
                        'class' => 'block w-full rounded-xl border border-slate-300 bg-white dark:bg-slate-800 px-4 py-3 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200',
                    ],
                    'label_attr' => [
                        'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                    ],
                    'help' => 'When do you want to achieve this goal?',
                    'constraints' => [
                        new NotBlank(),
                    ],
                ],
            )
        ;
    }
    public function configureOptions(
        OptionsResolver $resolver,
    ): void {
        $resolver->setDefaults([]);
    }
}
