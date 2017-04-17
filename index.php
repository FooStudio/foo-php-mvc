<?php
/**
 * Created by Foo()
 * Date: 4/16/17
 * Time: 8:25 AM
 */
require_once __DIR__ . '/vendor/autoload.php';

$app = App::getInstance();
$app->bootstrap();
//$app->setBasePath("/blog/");
$app->addRoute('GET', '/', 'HomeController#index', 'home');
$app->addRoute('GET', '/posts/[a:id]', 'PostsController#post', 'post');
$app->start();
