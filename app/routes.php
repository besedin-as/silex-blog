<?php


$app->mount('/', include 'routes/main-routes.php');
$app->mount('/article', include 'routes/article-routes.php');
$app->mount('/user', include 'routes/user-routes.php');
$app->mount('/posts', include 'routes/user-posts.php');
$app->mount('/admin', include 'routes/admin-routes.php');
$app->mount('/rest', include 'routes/post-routes.php');