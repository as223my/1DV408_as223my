<?php  

class LoginModel{
	private $password;
	private $username; 
	
	public function setPassword($value){
		$this->password = $value;
	}
	
	public function setUsername($value){
		$this->username = $value;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function checkIfLoggedIn(){
		if(!isset($_SESSION['username'])){
	 	 	return false; 
		}else{
			return true;
		} 
	}
	
	// Kollar om användarnamn och lösenord stämmer med de sparade uppgifterna i LoginModel.txt
	public function checkUserCredentials($username,$password){

		$file = fopen("model/LoginModel.txt", "r") or die("Unable to open file!");
		$fileName = fgets($file);
		$filePassword = fgets($file);
		fclose($file);
	
		if(trim($fileName) === $username && trim($filePassword) === $password){ // Om värderna stämmer tilldelas $_SESSION['username'] värdet i parametern. 
			$_SESSION['username'] = $username;
			$this->setPassword($password);
			$this->setUsername(trim($fileName)); 
			return true;		
		}else{
			return false;
		}
	}
	
	// Tömmer LoginCookies.txt på innehåll och skriver sedan in den sparade utgångstiden för kakorna.
	public function addTime($time){ 
		$fc= fopen( 'model/LoginCookies.txt', 'w' );
		fclose($fc);
	
		$fw = fopen("model/LoginCookies.txt", 'a');
		fwrite($fw , $time . "\n");
	}
	
	public function getTime() {
		$file = fopen("model/LoginCookies.txt", "r") or die("Unable to open file!");
		$fileTime = fgets($file);
		fclose($file);
		
		return $fileTime;
	}
	
	public function sessionStart(){
		session_start();
	}
	
	public function sessionDestroy(){
		session_destroy();
	}
	
	public function session($httpUserAgent){
	
		if(isset($_SESSION['httpUserAgent']) === false){
			$_SESSION["httpUserAgent"] = $httpUserAgent;
		
			return true;
		}
	
		if($_SESSION['httpUserAgent'] !== $httpUserAgent){
	
			return false;
		}
	}
}
