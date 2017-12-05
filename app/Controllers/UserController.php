<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceUserModel;


class UserController
{
	protected $userModel;

	public function __construct(InterfaceUserModel $userModel)
	{
		$this->userModel = $userModel;
	}

	public function index(Application $app)
	{
		return $app->redirect($app['url_generator']->generate("index.index"));
	}

    public function userCreatingPosts(Application $app)
    {
        return $app['twig']->render('user/content/user-creating-posts.twig', array());
    }

    public function create(Application $app, Request $request)
    {
        $createForm = $app['article_forms']->getCreateForm();
        $createForm->handleRequest($request);

        if ($createForm->isValid()) {
            $data = $createForm->getData();
            $this->userModel->createArticle($data['title'], $data['body'], $this->userModel->getId($app['user']));
        }

        return $app['twig']->render('user/content/user-create-post.twig', array(
            'createForm' => $createForm->createView()
        ));
    }

	public function login(Application $app, Request $request)
	{
		$loginForm = $app['user_forms']->getLoginForm();
		$loginForm->handleRequest($request);

		return $app['twig']->render('layout.twig', array(
			'error' => $app['security.last_error']($request),
			'last_username' => $app['session']->get('_security.last_username'),
			'loginForm' => $loginForm->createView()));
	}


	public function register(Application $app, Request $request)
	{
		$registerForm = self::doRegister($app, $request,  $this->userModel);
		if (!$registerForm) {
			return $app->redirect($app["url_generator"]->generate("user.login"));
		}
		return $app['twig']->render('layout.twig', array(
			'registerForm' => $registerForm->createView(),
			));
	}

	public function profile(Application $app, Request $request, $name)
	{
		$registerForm = self::doRegister($app, $request, $this->userModel);
		if (!$registerForm) {
			return $app->redirect($app["url_generator"]->generate("user.login"));
		}
		$profile = $this->userModel->getUser($name);
		return $app['twig']->render('profile/profile.twig', array(
				'registerForm' => $registerForm->createView(),
				'profile' => $profile
			));
	}

	public function own(Application $app)
	{
		$profile = $this->userModel->getUser($app['user']);
		return $app['twig']->render('profile/profile.twig', array(
				'profile' => $profile
			));
	}
	
	public function admin(Application $app)
	{
		echo $app['user'];
		return 'user-admin';
	}

	public function getUsername($id)
	{
		return $this->userModel->getUsername($id);
	}

	static function doRegister(Application $app, Request $request, InterfaceUserModel $userModel)
	{
		$form = $app['user_forms']->getRegisterForm();
		$form->handleRequest($request);

		if ($form->isValid()) {
			$data = $form->getData();
            $register = $userModel->registerUser($data['username'], $data['password'], $data['email'], 'ROLE_USER', $data['image']);
//            $register = $userModel->registerUser($data['username'], self::getPassword($data['password']), $data['email']);
		}

		if (isset($register)) {
			return !$register;
		} else {
			return $form;
		}
	}


//	static function getPassword($password)
//	{
//		return (new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder())->encodePassword($password, '');
//	}
}
