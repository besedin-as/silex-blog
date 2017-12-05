<?php 
$user = $app['controllers_factory'];
$user->get('/', 'user_controller:index')->bind('user.index');
$user->get('/admin', 'user_controller:admin')->bind('user.admin');


$user->get('/login', 'user_controller:login')->bind('user.login');
$user->post('/login', 'user_controller:login');

$user->get('/register', 'user_controller:register')->bind('user.register');
$user->post('/register', 'user_controller:register');

$user->get('/profile/{name}', 'user_controller:profile')->bind('user.profile');
$user->get('/profile', 'user_controller:own')->bind('user.own');

return $user;
