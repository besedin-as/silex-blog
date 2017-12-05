<?php

namespace forms;
use Silex\Application;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Models\ArticleModel;


class ArticleForm {
	protected $factory;
	protected $articleModel;

	public function __construct(FormFactory $factory, ArticleModel $articleModel) {
		$this->factory = $factory;
		$this->articleModel = $articleModel;
	}

	public function getCreateForm() {
		$form = $this->factory->createNamedBuilder('create', FormType::class)
		->add('title', TextType::class, array(
              'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
             ))
		->add('body', TextAreaType::class)
		->getForm();

		return $form;
	}
	public function getUpdateForm($id) {
		$article = array_shift($this->articleModel->getById($id));
		$form = $this->factory->createNamedBuilder('create', FormType::class)
		->add('title', TextType::class, array(
              'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))),
              'data' => $article['title']
             ))
		->add('body', TextAreaType::class, array(
				'data' => $article['body']
			))
		->getForm();

		return $form;
	}
	public function getCommentForm() {
		$form = $this->factory->createNamedBuilder('comment', FormType::class)
		->add('comment', TextAreaType::class, array(
			'constraints' => array(new Assert\NotBlank())
			))
		->getForm();

		return $form;
	}
}