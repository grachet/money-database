<?php


namespace IUT\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new NotBlank(array("message" => "Vous devez rentrer votre nom")),
                )
            ))
            ->add('subject', TextType::class, array(
                'constraints' => array(
                    new NotBlank(array("message" => "Vous devez rentrer votre sujet")),
                )
            ))
            ->add('email', EmailType::class, array(
                'constraints' => array(
                    new NotBlank(array("message" => "Vous devez rentrer votre email")),
                    new Email(array("message" => "Votre email ne semble pas valide")),
                )
            ))
            ->add('message', TextareaType::class, array(
                'constraints' => array(
                    new NotBlank(array("message" => "Vous devez rentrer votre message")),
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}