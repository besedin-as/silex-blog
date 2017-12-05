<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceArticleModel;
use Models\InterfaceUserModel;

class ArticleController
{
	protected $articleModel;
	protected $userModel;

	public function __construct(InterfaceArticleModel $articleModel, InterfaceUserModel $userModel) {
		$this->articleModel = $articleModel;
		$this->userModel = $userModel;
	}

	public function index(Application $app, Request $request)
	{
		if (!isset($_GET['page']) || isset($_GET['page']) == 0) {
			$page = 1;
		} else {
			$page = $app->escape($_GET['page']);
		}

		$lastPage = ($page - 1) * 5;
//		$posts = $this->articleModel->getAllArticles();

		$user = $app['user_controller'];
		$registerForm = $user::doRegister($app, $request, $this->userModel);
		if (!$registerForm) {
			return $app->redirect($app["url_generator"]->generate("user.login"));
		}
		return $app['twig']->render('article/all.twig', array(
			'registerForm' => $registerForm->createView()
//        , 'posts' => $posts
			));
	}

	public function getBySlug(Application $app, $slug)
	{
		$result = $this->articleModel->getBySlug($slug);
		if ($result == NULL) {
			$app->abort(404, "Post $slug does not exist.");
		}
		echo $result['title'];
		return true;
		//render twig template
	}

	public function getById(Application $app, Request $request, $id)
	{
		$posts = $this->articleModel->getById($id);
		if ($posts == NULL) {
			$app->abort(404, "Post $id does not exist.");
		}

		$user = $app['user_controller'];
		$registerForm = $user::doRegister($app, $request, $this->userModel);
		if (!$registerForm) {
			return $app->redirect($app["url_generator"]->generate("user.login"));
		}

		$comments = $this->articleModel->getComments($id);

		$commentForm = $app['article_forms']->getCommentForm();
		$commentForm->handleRequest($request);
		if ($commentForm->isValid()) {
			$commentData = $commentForm->getData();
			$comment = $this->articleModel->addComment($commentData['comment'], $this->userModel->getId($app['user']), $id, $request->getClientIp());
			if ($comment) {
				return $app->redirect($request->getRequestUri());
			}
		}
		return $app['twig']->render('article/current.twig', array(
				'registerForm' => $registerForm->createView(),
				'commentForm' => $commentForm->createView(),
				'posts' => $posts,
				'comments' => $comments
			));
	}
}
