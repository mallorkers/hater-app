<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require '../3rd_party/vendor/autoload.php';

$slim = new \Slim\Slim();

use haterApp\Test;
$test = new Test();

$slim->get('/test', function(){
  $loader = new Twig_Loader_Filesystem('../app/templates');
  $twig = new Twig_Environment($loader);
  echo $twig->render('html.html', array());
});

$slim->get('/:name', function($name){
  echo 'QUE PASA ' . $name;
});

$slim->run();