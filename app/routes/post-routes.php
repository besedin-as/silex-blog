<?php

$post = $app['controllers_factory'];
$post->post('/allPosts', 'posts_controller:getAllPosts');
$post->get('/allPosts', 'posts_controller:getAllPosts');
$post->get('/post{id}', 'posts_controller:getById');

return $post;