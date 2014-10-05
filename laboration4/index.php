<?php

require_once("src/view/HTMLPage.php");
require_once("src/controller/LoginController.php");

session_start();

$pageView = new \view\HTMLPage();

$loginController = new \controller\LoginController();
$body = $loginController->doControll();

$pageView->getPage($body);
   
   
  
  
