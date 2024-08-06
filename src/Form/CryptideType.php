<?php

namespace App\Form;

use App\Entity\Continent;
use App\Entity\Cryptide;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CryptideType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => ''
            ])
            ->add('slug', TextType::class, [
                'empty_data' => ''
            ])
            ->add('pays', TextType::class, [
                 'empty_data' => ''
            ])
            ->add('idContinent', EntityType::class, [
                'class' => Continent::class,
                'choice_label' => 'nom',
                'empty_data' => ''
            ])
            ->add('description', TextareaType::class, [
                'empty_data' => ''
            ])
            ->add('img', TextType::class, [
                'empty_data' => ''
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->preSubmit(...))
        ;
    }

    public function preSubmit(PreSubmitEvent $event):void {
        $data = $event->getData();
        if (empty($data['slug'])) {
            $newSlug = new AsciiSlugger();
            $data['slug'] = strtolower($newSlug->slug($data['name']));
        }
        if (empty($data['idContinent'])) {
            $data['idContinent'] = 8;
        }
        $event->setData($data);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cryptide::class,
        ]);
    }
}
