<?php

class LoginView{
	
	private $time;
	private $timeLengthCookie; 
	
	public function __construct(){
		$this->timeLengthCookie = 3600*24*30; // En månad i sekunder.	
	}
	
	public function setTime($timeFromCookie){
		$this->time = $timeFromCookie; 
	}
	
	public function getTime(){
		return $this->time;
	}
	
	public function getHttpUserAgent() {
		return $_SERVER["HTTP_USER_AGENT"];
	}
	
	public function didUserPressLogin(){
		if(isset($_POST["login"])){
			return true;
		}else{
			return false;
		}	
	}
	
	public function didUserPressLogout(){
		if(isset($_POST["logout"])){
			return true;
		}else{
			return false;
		}	
	}
	
	public function getInputUsername(){
		$username = $_POST['username'];
		return $username;
	}
	
	public function getInputPassword(){
		$password = $_POST['password'];
		return $password; 
	}

 // -------------COOKIES-------------------------------------- 
 
	public  function getCookieUsername(){
		if(isset($_COOKIE["username"])){
			return $_COOKIE["username"];
		}else{
			return "";
		}		
	}
	
	public  function getCookiePassword(){
		if(isset($_COOKIE["password"])){
			return $_COOKIE["password"];
		}else{
			return "";
		}		
	}
		
	public function saveCookies($username, $password){
		setcookie("username",$username,time() + $this->timeLengthCookie,'/');
		setcookie("password",$password,time() + $this->timeLengthCookie,'/');
		$this->setTime(time() + $this->timeLengthCookie); 
	}
	
	public function deleteCookies(){
		setcookie('username', '', time() - $this->timeLengthCookie, '/');
		setcookie('password', '', time() - $this->timeLengthCookie,'/');
	}
	
// -------------------------------------------------------------
	
	// Om checkboxen är ifylld spara kakor. Skicka med sparade värden för username och password. 
	public function checkbox(LoginModel $model){
		
		if(isset($_POST["checkbox"])){
			
			$this->saveCookies($model->getUsername(),$model->getPassword());
	
			return true;
		}else{
			return false;
		}	
	}
	
	// Kontrollerar inskrivna värden i formuläret. 	
	public function controllInput(){
		
		$username = $this->getInputUsername(); 
		$password = $this->getInputPassword();
		
		if($password === "" && $username === ""){
			return "Användarnamn saknas"; 
		}
		else if($password === ""){
			return "Lösenord saknas";
		}
		else if($username === ""){
			return "Användarnamn saknas";
		}else{
			return "Användarnamn och lösenord är angett";
		}		
	}
	
	// Innehållet som visas om man ej är inloggad.
	public function showLogin($message){
		
		$content = "
		<h1>Laborationskod as223my</h1>
		<h2>Ej inloggad</h2>
		<form action='?login' method='post'>
  			<fieldset>
    			<legend> Login - skriv in användarnamn och lösenord </legend>
    			<p>$message</p>
   	 			Användarnamn: <input type='text' name='username'>
    			Lösenord: <input type='text' name='password'>
    			Håll mig inloggad <input type='checkbox' name='checkbox'>
    			<input type='submit' name='login' value='Logga in'>
  			</fieldset>
		</form>" ;
		
		return $content; 
	}
	
	// Innehållet som visas om man är inloggad.
	public function showLoginSuccessful($message){
		
		$content = "
		<h1>Laborationskod as223my</h1>
		<h2>Admin är inloggad</h2>
		<p>$message</p>
		<form action='#' method='post'><input type='submit' name='logout' value = 'Logga ut'></form>" ;
		
		return $content; 
	}
}
