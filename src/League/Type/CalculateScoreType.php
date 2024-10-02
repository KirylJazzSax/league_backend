<?php

declare(strict_types=1);

namespace App\League\Type;

use App\League\Dto\CalculateScoreActionInputDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculateScoreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class)
            ->add('matches', CollectionType::class, [
                'entry_type' => MatchType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('dryRun', TextType::class)
            ->add('week', TextType::class);

        $builder->get('dryRun')->addModelTransformer(
            new BooleanToStringTransformer('true', ['false', false, null])
        );
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CalculateScoreActionInputDto::class,
            'csrf_protection' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
