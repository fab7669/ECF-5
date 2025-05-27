<?php


namespace App\Form;

use App\Entity\Enfant;
use App\Entity\Responsable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnfantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('allergies', TextareaType::class, [
                'label' => 'Allergies',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 3]
            ])
            ->add('responsables', EntityType::class, [
                'class' => Responsable::class,
                'choice_label' => function(Responsable $responsable) {
                    return $responsable->getPrenom() . ' ' . $responsable->getNom();
                },
                'multiple' => true,
                'expanded' => true,
                'label' => 'Responsables légaux existants',
                'required' => false
            ])
            ->add('nouveauResponsable', ResponsableType::class, [
                'label' => 'Nouveau responsable légal',
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enfant::class,
        ]);
    }
}