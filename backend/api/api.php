<?php

require_once dirname(__DIR__) . '/controllers/DomaineController.php';

$controller = new DomaineController();
$controller->handleRequest();