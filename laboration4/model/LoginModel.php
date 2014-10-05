<?php
namespace model;

require_once("src/view/LoginView.php");
require_once("src/model/UserRepository.php");

class LoginModel{
    
    private $userRepository;
    
    public function __construct(){
        $this->userRepository = new \model\UserRepository();
    }

	//Funktion för att kolla om användaren är inloggad
	public function isLoggedIn(){
		if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == "yes") {
			return true;
		} 
		else {
			return false;
		}
	}

	//Funktion för att kontrollera inloggningsuppgifter
	public function doLogin($name, $password){
		switch ($this->userRepository->checkBeforeLogin($name, $password)){
			case true:
			    
				$_SESSION['LoggedIn'] = "yes";
				$_SESSION['name'] = $name;
				//spara undan IP
				$sessionIdentifier = $_SERVER['HTTP_USER_AGENT'];
				$this->saveToFile($sessionIdentifier);
				return true;
				
			break;
		}
		
	return false;	
	}

	public function getSessionName(){
		if (isset($_SESSION['name'])){
			return $_SESSION['name'];
		} else {
			return "";
		}
	}

	//Funktion för att spara användarinfo 
	public function saveToFile($encryptedUser){
		$file = fopen('logins.txt', 'a');
		fwrite($file, $encryptedUser . "\n");
	}

	//Funktion för att kontrollera Cookien vid automatisk inloggning
	public function cookieSecurityCheck($stringToVerify){
		$lines = @file("logins.txt");
		//om filen inte finns
		if ($lines === false) {
			return false;
		}
		else{
			foreach ($lines as $line) {
				$line = trim($line);
				if ($line === $stringToVerify) {
					return true;
				}
			}
			return false;
		}	
	}

	//Funktion för att radera i filen tillhörande utloggad användare
	public function removeClientIdentifier($name){
	 
		//rename("logins.txt", "logins_temp.txt");
		$rows = @file("logins.txt");
		if ($rows == false) {
			return null;
		} 
		else {
			$content = "";
			foreach ($rows as $row) {
				$row = trim($row);
				//$checkRow = explode(",", $row);
				//$checkRow = $checkRow[0];
				if (!strpos($row, $name) == 0) {
					$content .= $row . "\n";
				}
			}
			$file = fopen('logins.txt', 'w+');
			fwrite($file, $content);
		}
	}

	//Funktion för utloggning
	public function doLogout($sessionIdentifier){
	  
		$this->removeClientIdentifier($sessionIdentifier);
		session_destroy();

	    return "Du har nu loggat ut!";
	}
}
