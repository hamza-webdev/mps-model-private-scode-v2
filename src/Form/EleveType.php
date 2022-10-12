<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Gendre;
use App\Entity\Guardian;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('dateNaissance')
            ->add('photo')
            ->add('desciption', TextareaType::class)
            ->add('dateInsriptionAt')
            ->add('gendre', EntityType::class, [
                'class'    => Gendre::class,
                'expanded' => true

            ])
            ->add('guardian', EntityType::class, [
                'class'    => Guardian::class,
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                    },

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
