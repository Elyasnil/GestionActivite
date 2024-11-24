<?php

namespace App\Form;

use App\Entity\Assistance;
use App\Entity\Referentiel\CanalDemande;
use App\Entity\Referentiel\SourceDemande;
use App\Entity\Referentiel\Statut;
use App\Entity\Referentiel\TypeDemande;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssistanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_creation', null, [
                'widget' => 'single_text',
            ])
            ->add('Source', EntityType::class, [
                'class' => SourceDemande::class,
                'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => TypeDemande::class,
                'choice_label' => 'id',
            ])
            ->add('canal', EntityType::class, [
                'class' => CanalDemande::class,
                'choice_label' => 'id',
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'id',
            ])
            ->add('responsable', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assistance::class,
        ]);
    }
}
