<?php


namespace App\form\type;


use App\Entity\Category;
use App\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('releaseDate', DateType::class,array(
                'years' => range(date('Y')-100, date('Y')),
            ))
            ->add('description', TextType::class,['required' => true, 'constraints' => [new Length(['min' => 5]), new Length(['max' => 100])]])
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('realisator', EntityType::class, [
                // looks for choices from this entity
                'class' => Person::class,
                'choice_label' => 'lastname',
            ])
            ->add('casting', EntityType::class, [
                // looks for choices from this entity
                'class' => Person::class,
                'choice_label' => 'lastname',
                'multiple' => 'true'
            ])
            ->add('save', SubmitType::class)
        ;
    }


}