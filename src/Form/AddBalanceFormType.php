<?php

namespace App\Form;

use App\Entity\Balance;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBalanceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('market', TextType::class, [
                'label' => 'Market'
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount'
            ])
            ->add('price', NumberType::class, [
                'label' => 'Start price'
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Create balance'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Balance::class,
        ]);
    }
}
