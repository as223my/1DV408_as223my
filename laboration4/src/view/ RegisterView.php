<?php
namespace view;

require_once("src/view/LoginView.php");

class RegisterView{ // Registreringsvyn. 
	private $loginView;

	public function __construct(){
		$this->loginView = new \view\LoginView();
	}
	
	public function getName(){
		$name = $_POST['name'];
		return $name;
	}
		
	public function getPassword1(){
		$password1 = $_POST['password1'];
		return $password1;
	}
	
	public function getPassword2(){
		$password2 = $_POST['password2'];
		return $password2;
	}
	
	public function doRegisterView($nameMessage, $passwordMessage, $valueName){
		$time = $this->loginView->getDateAndTime();
		return "
		<h1>Laborationskod as223my</h1>
		<a href='./'>Tillbaka</a>
		<h2>Ej inloggad, Registera användare</h2>
		<form action='#' method='post'>
		<fieldset>
		<legend>Registera ny användare - Skriv in användarnamn och lösenord</legend>
		<p>$nameMessage</p>
		<p>$passwordMessage</p>
		Namn: <input type='text' name='name' value='$valueName' maxlength='50'></br>
		Lösenord: <input type='password' name='password1' maxlength='50'></br>
		Repetera lösenord: <input type='password' name='password2' maxlength='50'></br></br>
		
		Skicka: <input type='submit' name='regUser' value='Registrera'>
		</fieldset>
		</form>
		<p>$time</p>"
		;
	}
	
}
