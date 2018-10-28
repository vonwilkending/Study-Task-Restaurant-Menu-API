<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//reffer to slim dependencies
require '../vendor/autoload.php'; 
$app = new \Slim\App;

require '../src/db.php';
require '../src/scraper.php';

//Data Routes
require '../src/api.php';
$app->run();



