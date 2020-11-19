<?php

session_start();

require_once('errorSettings.php');
require_once('controller/Application.php');

$app = new \Controller\Application();

$app->run();




