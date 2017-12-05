<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceMainModel;
use Models\InterfaceUserModel;

class MainController
{
	protected $mainModel;
	protected $userModel;

	public function __construct(InterfaceMainModel $mainModel, InterfaceUserModel $userModel)
	{
		$this->mainModel = $mainModel;
		$this->userModel = $userModel;
	}

	public function index(Application $app, Request $request)
	{
		$user = $app['user_controller'];
		$registerForm = $user::doRegister($app, $request, $this->userModel);
        if (!$registerForm) {
			return $app->redirect($app["url_generator"]->generate("user.login"));
		}

		$posts = $this->mainModel->getMainArticles();
		return $app['twig']->render('article/index.twig', array(
				'registerForm' => $registerForm->createView(),
				'posts' => $posts
			));
	}
}
