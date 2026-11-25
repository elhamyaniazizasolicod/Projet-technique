<?php

require_once dirname(__DIR__) . '/controllers/MatiereController.php';

$controller = new MatiereController();
$controller->handleRequest();