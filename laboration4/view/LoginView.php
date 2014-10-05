<?php
namespace view;

use DateTime;
class LoginView{

	private $getKey_name = "name";
	private $getKey_password = "password";
	private $getKey_loginButton = "loginButton";
	private $getKey_logoutButton = "logoutButton";
	private $getKey_rememberMeBox = "rememberMeBox";
	
	//Funktion som visar inloggningsruta
	public function doLoginPage($message,$name){
		$time = $this->getDateAndTime();
		return "
		<h1>Laborationskod as223my (mg222cd)</h1>
		<h2>Ej inloggad</h2>
		<div id='link'><p><form action='?register' method='post'><input type='submit' name='reg' value = 'Registrera ny användare'></form></p></div>
		<form action='' method='post'>
		<fieldset>
		<legend>Login - skriv in användarnamn och lösenord</legend>
		<p>$message</p>
		Namn:<input type='text' name='name' value=$name>
		Lösenord:<input type='password' name='password'>
		Håll mig inloggad<input type='checkbox' name='rememberMeBox'>
		<input type='submit' name='loginButton' value='Logga in'>
		</fieldset>
		</form>
		<p>$time</p>";
	}

	//Funktion som kollar om användaren tryckt på Logga in-knappen
	public function triedToLogin(){
		if(isset($_POST['loginButton'])){
			return true;
		}else{
			return false;
		}
	}

	//Funktion som visar sida när man är inloggad.
	public function loggedInPage($name,$message){
		$time = $this->getDateAndTime();
		return "
		<h1>Laborationskod as223my (mg222cd)</h1>
		<h2>$name är inloggad</h2>
		<form action='' method='post'>
		<p>$message</p>
		<input type='submit' name='logoutButton' value='Logga ut'>	
		</form>
		<p>$time</p>
		";
	}

	//Funktion som kollar om användaren tryckt på Logga ut-knappen
	public function triedToLogout(){
		if (isset($_POST['logoutButton'])) {
			return true;
		} 
		else {
			return false;
		}	
	}

	//Funktion som returnerar aktuellt datum och tid
	public function getDateAndTime(){
	    date_default_timezone_set("Europe/Stockholm");
		setlocale (LC_ALL, "sv_SE");
		$date = date('d F');
		$year = date('Y');
		$day = ucfirst(strftime("%A"));
		$time = date('H:i:s');
		return utf8_encode($day) . ', den ' . $date . ' år ' . $year . '. Klockan är [' . $time . ']';
	}

	//Funktion för att hämta angivet användarnamn
	public function getName(){
		if (isset($_POST['name'])) {
			return $_POST['name'];
		}
		return  false;
	}

	//Funkrion för att hämta angivet lösenord
	public function getPassword(){
		if (isset($_POST['password'])) {
			return $_POST['password'];
		}
		return false;
	}

	//Funktion för att kontrollera "Håll mig inloggad"-checkboxen
	public function checkBox(){
		if (isset($_POST[$this->getKey_rememberMeBox])) {
			return true;
		} 
		else {
			return false;
		}
	}

	//Funktion för att klientens IP
	public function getClientIdentifier(){
		return $_SERVER['HTTP_USER_AGENT'];
	}

	//Funktion som kollar om användaren tryckt på registrera
	public function register(){
		if (isset($_POST['reg'])){
			return true;
		} 
		else {
			return false;
		}	
	}
	
	//Funktion som kollar om användaren tryckt på registrera ny användare
	public function registerNewUser(){
		if (isset($_POST['regUser'])) {
			return true;
		} 
		else {
			return false;
		}	
	}
}
