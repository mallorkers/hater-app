<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require '../3rd_party/vendor/autoload.php';

$slim = new \Slim\Slim();

$slim->get('/test', function(){
  echo 'QUE PASA TIO';
});

$slim->run();