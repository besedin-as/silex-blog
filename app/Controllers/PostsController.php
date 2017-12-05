<?php

namespace Controllers;

use Models\InterfaceAdminModel;
use Silex\Application;
use function Sodium\add;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceArticleModel;
use Models\InterfaceUserModel;

class PostsController
{
    protected $articleModel;
    protected $userModel;
    protected $adminModel;

    public function __construct(InterfaceArticleModel $articleModel, InterfaceUserModel $userModel, InterfaceAdminModel $adminModel)
    {
        $this->articleModel = $articleModel;
        $this->userModel = $userModel;
        $this->adminModel = $adminModel;
    }

    public function getAllPosts(Application $app, Request $request)
    {
        if ($request->isMethod('GET')) {
            $posts = $this->articleModel->getAllArticles(1000, 0);
            foreach ($posts as &$post) {
                $post['user_name'] = $this->userModel->getUsername($post['id_user']);
                $post['comments'] = $this->articleModel->getComments($post['id']);
            }
            return $app->json($posts);
        } else {
            $from = $request->request->get('from');
            $posts = $this->articleModel->getAllArticles(10, $from);
            foreach ($posts as &$post) {
                $post['user_name'] = $this->userModel->getUsername($post['id_user']);
                $post['comments'] = $this->articleModel->getComments($post['id']);
            }
            return $app->json($posts);
        }
    }

    public function getById(Application $app, Request $request, $id)
    {
        $post = $this->articleModel->getById($id);
        if ($post == NULL) {
            $app->abort(404, "Post $id does not exist.");
        }
        $post[0]['user_name'] = $this->userModel->getUsername($post[0]['id_user']);
        $post[0]['comments'] = $this->articleModel->getComments($post[0]['id']);
        return $app->json($post);
    }

    public function sendNewPost(Application $app, Request $request)
    {
        $title = $request->request->get('title');
        $body = $request->request->get('body');
        $this->adminModel->createArticle($title, $body);
        return array("status"=>'ok');
    }
}