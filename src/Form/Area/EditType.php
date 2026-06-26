<?php

namespace App\Form\Area;

use App\Goal\Application\UseCase\GetGoalListUseCase;
use App\Identity\Domain\ValueObject\UserId;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditType extends AbstractType
{
    public function __construct(
        private readonly GetGoalListUseCase $getGoalListUseCase,
        private readonly Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Name',
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
                'required' => false,
            ])
            ->add('goalId', ChoiceType::class,[
                'choices' =>  $this->getGoalListUseCase
                    ->execute(
                        UserId::fromString($this->security->getUser()->getUserIdentifier()),
                    ),
                'choice_label' => 'title',
                'choice_value' => 'id',
                'label' => 'Goal',
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
                'placeholder' => 'What do you want to achieve?',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
        ;
    }

}
