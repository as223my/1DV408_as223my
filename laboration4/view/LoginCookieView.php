<?php
namespace view;

class LoginCookieView{
    
	//Funktion för att kryptera password
	public function encryptPassword($password){
		//$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
		$encryptedPassword = md5($password);
		return $encryptedPassword;
	}
	
	//Funktion för att sätta Cookies
	public function createCookie($name, $password){
	    $timeLength = 3600*24*30;
	    
		$_COOKIE['name'] = $name;
		setcookie("name", $name, time()+$timeLength,"/");
		
		$_COOKIE['password'] = $password;
		setcookie("password", $password, time()+$timeLength,"/");
		
		$timeStamp = time()+$timeLength;
		$_COOKIE['timeStamp'] = $timeStamp;
		setcookie("timeStamp", $timeStamp, time()+$timeLength,"/");
	}

	//funktion för att hämta IP-adressen från vilken klienten ser på sidan
	public function getClientIdentifier(){
		return $_SERVER["REMOTE_ADDR"];
	}
	
	// kollar om tiden är giltlig i cookie.
	public function checkTime(){
		$time = $this->getCookieTimestamp(); 
		if($time < time()){
			return false;
		}
		return true;
	}

	//Funktion för att göra unik sträng av Cookie-informationen
	public function pickupCookieInformation($encryptedPassword){
		$uniqueString = $encryptedPassword . $_COOKIE['timeStamp'] . $this->getClientIdentifier();
		return $_COOKIE['name'] . "," . md5($uniqueString);
	}

	//Funktion för att hämta name i Cookie
	public function getCookieName(){
		if (isset($_COOKIE['name'])) {
			return $_COOKIE['name'];
		} 
		else {
			return null;
		}
	}
	
	public function getCookieTimestamp(){
		if (isset($_COOKIE['timeStamp'])) {
			return $_COOKIE['timeStamp'];
		} 
		else {
			return null;
		}
	}

	//Funktion för att hämta password i Cookie
	public function getCoookiePassword(){
		if (isset($_COOKIE['password'])) {
			return $_COOKIE['password'];
		} 
		else {
			return null;
		}
	}

	//Funktion för att ta bort Cookies
	public function removeCookie(){
		if (isset($_COOKIE['name']) || isset($_COOKIE['password']) || isset($_COOKIE['timeStamp'])) {
		    $timeLength = 3600*24*30;
			setcookie("name", "", time()-$timeLength,"/");
			setcookie("password", "", time()-$timeLength,"/");
			setcookie("timeStamp", "", time()-$timeLength,"/");
		} 
		else {
			return null;
		}
	}
}
