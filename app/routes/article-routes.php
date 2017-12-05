<?php 
$article = $app['controllers_factory'];
$article->get('/', 'article_controller:index')->bind('article.index');
$article->get('/{id}', 'article_controller:getById')->bind('article.id');
$article->post('/{id}', 'article_controller:getById');
$article->get('/slug/{slug}', 'article_controller:getBySlug');

return $article;