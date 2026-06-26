<?php

namespace App\Form\Task;

use App\Area\Application\UseCase\GetAreaListUseCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateType extends AbstractType
{
    public function __construct(
        private readonly GetAreaListUseCase  $getAreaListUseCase,
        private readonly Security $security,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('areaId', ChoiceType::class, [
                'choices' =>  $this->getAreaListUseCase->execute(
                    $this->security->getUser()->getUserIdentifier(),
                ),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => 'Area',
                'label_attr' => [
                    'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                ],
                'attr' => [
                    'class' => '
                        w-full
                        rounded-xl
                        border
                        border-slate-200
                        px-4
                        py-3
                        focus:border-slate-400
                        focus:outline-none
                    ',
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true,
            ])
            ->add('title', TextType::class,[
                'label' => 'Title',
                'label_attr' => [
                    'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                ],
                'attr' => [
                    'class' => '
                        w-full

                        rounded-xl
                        border
                        border-slate-200

                        px-4
                        py-3

                        focus:border-slate-400
                        focus:outline-none
                    ',
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true,

            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                ],
                'attr' => [
                    'class' => '
                        w-full
                        rounded-xl
                        border
                        border-slate-200

                        px-4
                        py-3

                        focus:border-slate-400
                        focus:outline-none
                    '
                ]
            ])
            ->add('nextAction', TextareaType::class,[
                'label' => 'Next Action',
                'label_attr' => [
                    'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                ],
                'attr' => [
                    'class' => '
                        w-full
                        rounded-xl
                        border
                        border-slate-200

                        px-4
                        py-3

                        focus:border-slate-400
                        focus:outline-none
                    '
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true,
            ])
            ->add('estimatedMinutes', NumberType::class,[
                'label' => 'Estimated Minutes',
                'label_attr' => [
                    'class' => 'mb-2 block text-sm font-medium dark:text-slate-100 text-slate-700',
                ],
                'attr' => [
                    'placeholder' => 'Minutes needed',
                    'min' => 1,
                    'step' => 5,
                    'class' => '
                        w-full

                        rounded-xl
                        border
                        border-slate-200

                        px-4
                        py-3

                        focus:border-slate-400
                        focus:outline-none
                    '
                ],
                'html5' => true,
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true,
            ])
        ;
    }
}
