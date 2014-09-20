<?php
require_once("controller/LoginController.php");
require_once("view/HTMLView.php");

$controller = new LoginController();
$content= $controller->doLogin(); 

$view = new HTMLView(); 
$view->echoHTML($content);

