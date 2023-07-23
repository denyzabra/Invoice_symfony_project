<?php
// src/Form/InvoiceType.php

namespace App\Form;

use App\Entity\Invoice; // Add this use statement for the Invoice entity
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('invoiceDate', DateType::class)
            ->add('invoiceNumber', IntegerType::class)
            ->add('customerId', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Create invoice'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}

