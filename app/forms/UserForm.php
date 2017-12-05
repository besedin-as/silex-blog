<?php

namespace forms;

use Silex\Application;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserForm
{

    protected $factory;

    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getLoginForm()
    {
        $form = $this->factory->createNamedBuilder(null, FormType::class)
            ->add('_username', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
                )
            )
            ->add('_password', PasswordType::class)
            ->getForm();

        return $form;
    }

    public function getRegisterForm()
    {
        $form = $this->factory->createNamedBuilder('register', FormType::class)
            ->add('username', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)
                    )),
                    'error_bubbling' => false
                )
            )
            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                    'error_bubbling' => false,
                    'constraints' => array(new Assert\Length(array('min' => 6)))
                )
            )
            ->add('email', EmailType::class, array(
                    'constraints' => array(new Assert\Email(array(
                        'message' => 'The email "{{ value }}" is not a valid email.',
                        'checkMX' => true,
                    )),
                        new Assert\Length(array('min' => 8))
                    ),
                    'error_bubbling' => false,
                )
            )
            ->add('image', FileType::class, array(
                'attr' => array(
                    'multiple' => 'multiple'
                )
            ))
            ->getForm();

        return $form;
    }
}