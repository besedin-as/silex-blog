<?php
$posts = $app['controllers_factory'];

$posts->get('/creatingPosts', 'user_controller:userCreatingPosts')->bind('user.creating.posts');
$posts->get('/create', 'user_controller:create')->bind('user.create');
$posts->post('/create', 'user_controller:create')->bind('user.create.post');

return $posts;