<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceAdminModel;
use Models\InterfaceUserModel;
use Models\InterfaceArticleModel;

class AdminController
{
	protected $adminModel;
	protected $userModel;
	protected $articleModel;

	public function __construct(InterfaceAdminModel $adminModel, InterfaceUserModel $userModel, InterfaceArticleModel $articleModel)
	{
		$this->adminModel = $adminModel;
		$this->userModel = $userModel;
		$this->articleModel = $articleModel;
	}

	public function index(Application $app)
	{
		return $app['twig']->render('admin/content/admin-index.twig', array());
	}

	public function create(Application $app, Request $request)
	{
		$createForm = $app['article_forms']->getCreateForm();
		$createForm->handleRequest($request);

		if ($createForm->isValid()) {
			$data = $createForm->getData();
			$this->adminModel->createArticle($data['title'], $data['body'], $this->userModel->getId($app['user']));
		}
		
		return $app['twig']->render('admin/content/admin-create.twig', array(
				'createForm' => $createForm->createView()
			));
	}

	public function update(Application $app, Request $request)
	{
        if (!isset($_GET['page']) || isset($_GET['page']) == 0) {
            $page = 1;
        } else {
            $page = $app->escape($_GET['page']);
        }

        $lastPage = ($page - 1) * 5;
		$posts = $this->articleModel->getAllArticles($lastPage);
		return $app['twig']->render('admin/content/admin-update-list.twig', array(
				'posts' => $posts
			));
	}

	public function updateArticle(Application $app, Request $request, $id)
	{

		$updateForm = $app['article_forms']->getUpdateForm($id);
		$updateForm->handleRequest($request);

		if ($updateForm->isValid()) {
			$data = $updateForm->getData();
			$this->adminModel->updateArticle($id, $data['title'], $data['body']);
		}

		return $app['twig']->render('admin/content/admin-update-article.twig', array(
				'updateForm' => $updateForm->createView()
			));
	}

	public function removeArticle(Application $app, $id)
	{
		$this->adminModel->removeArticle($id);
		return $app->redirect($app['url_generator']->generate("admin.update"));
	}

	public function users(Application $app)
	{
		if (!isset($_GET['page']) || isset($_GET['page']) == 0) {
			$page = 1;
		} else {
			$page = $app->escape($_GET['page']);
		}

		$lastPage = ($page - 1) * 5;
		$users = $this->userModel->getAllUsers($lastPage);

		return $app['twig']->render('admin/content/admin-users.twig', array(
				'users' => $users,
			));
	}

	public function removeUser(Application $app, $id)
	{
		$this->adminModel->removeUser($id);
		return $app->redirect($app['url_generator']->generate("admin.users"));
	}
 }
