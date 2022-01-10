<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('nbPage')
            ->add('dateEdition', DateType::class,
            ['widget'=>'single_text'])

            ->add('nbExemplaires')
            ->add('prix',NumberType::class,
                ['attr' => ['empty_data' => 0]]) // niveau BD valeur par defaut
            // ['attr' => ['value' => 0]])  niveau formulaire
            ->add('isbn',NumberType::class,
            ['attr' => ['placeholder' => 'isbn sur 8 chiffres']])
            ->add('editeur')
            ->add('categorie')
            ->add('auteur'
                /*,EntityType::class,[
                'class'=>Auteur::class,
                'multiple' =>true,
                'expanded' =>false,
                'choice_label' => function($auteur){
                return $auteur -> getPrenom().' '.$auteur ->getNom();
                }
                ]*/
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }

}
