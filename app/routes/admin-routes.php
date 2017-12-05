<?php 
$admin = $app['controllers_factory'];
$admin->get('/', 'admin_controller:index')->bind('admin.index');

$admin->get('/create', 'admin_controller:create')->bind('admin.create');
$admin->post('/create', 'admin_controller:create')->bind('admin.create.post');

$admin->get('/update', 'admin_controller:update')->bind('admin.update');
$admin->post('/update', 'admin_controller:update')->bind('admin.update.post');

$admin->get('/update/{id}', 'admin_controller:updateArticle')->bind('admin.update.article');
$admin->post('/update/{id}', 'admin_controller:updateArticle')->bind('admin.update.article.post');

$admin->get('/update/remove/{id}', 'admin_controller:removeArticle')->bind('admin.remove.article');

$admin->get('/users', 'admin_controller:users')->bind('admin.users');
$admin->post('/users', 'admin_controller:users');

$admin->get('/users/remove/{id}', 'admin_controller:removeUser')->bind('admin.remove.user');

return $admin;