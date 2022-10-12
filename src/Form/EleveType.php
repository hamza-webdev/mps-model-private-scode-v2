<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Gendre;
use App\Entity\Guardian;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('photo', FileType::class, [
                'label' => 'Votre Phhoto (JPG GIF PNG file)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '3M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG, JPEG, PNG PDF document',
                        'maxSizeMessage' => 'Votre image est trop lourde: maximum 1MO'
                    ])
                ],
            ])
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
