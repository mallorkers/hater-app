<?php

error_reporting(E_ALL); //Change this in production
ini_set('display_errors', '1');
require '../3rd_party/vendor/autoload.php';

$slim = new \Slim\Slim();

$loader = new Twig_Loader_Filesystem('../app/templates');
$twig = new Twig_Environment($loader);

$slim->get('/', function() use ($twig){
	echo $twig->render('mainpage.html', array() );
});

$slim->get('/test', function() use ($twig){
  echo $twig->render('html.html', array());
});

$slim->get('/test2', function() use ($twig){
  echo $twig->render('html2.html', array());
});

$slim->get('/env_vars', function(){
  var_dump(getenv('USER'))."\n";
});

$slim->get('/:name', function($name){
  echo 'QUE PASA ' . $name;
});

$slim->run();