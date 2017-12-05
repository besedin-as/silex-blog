<?php
$loader = require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;


$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'silex_blog_db',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ),
    )
);

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());


$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'foo' => array('pattern' => '^/foo'), // Example of an url available as anonymous user
        'default' => array(
            'pattern' => '^.*$',
            'anonymous' => true, // Needed as the login path is under the secured area
            'form' => array('login_path' => '/user/login', 'check_path' => '/admin/login_check'),
            'logout' => array('logout_path' => '/logout'), // url to call for logging out
            'users' => function ($app) {
                // Specific class App\User\UserProvider is described below
                return new Models\UserProvider($app['db']);
            },
        ),
    ),
    'security.access_rules' => array(
        // array('^/.+$', 'ROLE_USER'),
        array('/admin/.+$', 'ROLE_ADMIN'),
        array('^/admin$', 'ROLE_ADMIN'),
        array('^/foo$', ''), // This url is available as anonymous user
    )
));

$app['uploadcare'] = function ($app) {
    return new \Uploadcare\Api('fedb3e65b4040608c27c', '0141110b17072c2bbcb3');
};

//make share forms

$app['user_forms'] = function ($app) {
    return new forms\UserForm($app['form.factory']);
};

$app['article_forms'] = function ($app) {
    return new forms\ArticleForm($app['form.factory'], new Models\ArticleModel($app['db']));
};
$app['user_model'] = function ($app) {
    return new Models\UserModel($app['db']);
};
$app['article_model'] = function ($app) {
    return new Models\ArticleModel($app['db']);
};

$app['main_controller'] = function ($app) {
    return new Controllers\MainController(new Models\MainModel($app['db']), new Models\UserModel($app['db']));
};
$app['posts_controller'] = function ($app) {
    return new Controllers\PostsController(new Models\ArticleModel($app['db']), new Models\UserModel($app['db']), new Models\AdminModel($app['db']));
};
$app['article_controller'] = function ($app) {
    return new Controllers\ArticleController(new Models\ArticleModel($app['db']), new Models\UserModel($app['db']));
};
$app['user_controller'] = function ($app) {
    return new Controllers\UserController(new Models\UserModel($app['db']));
};
$app['admin_controller'] = function ($app) {
    return new Controllers\AdminController(new Models\AdminModel($app['db']), new Models\UserModel($app['db']), new Models\ArticleModel($app['db']));
};

require 'routes.php';
$app->run();