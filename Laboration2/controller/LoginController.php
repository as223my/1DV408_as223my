<?php
require_once("view/LoginView.php");
require_once("model/LoginModel.php");

class LoginController{
	private $view; 
	private $model; 
	
	public function __construct(){
		$this->view = new LoginView();
		$this->model = new LoginModel(); 	
	}
	
	// Kollar om det finns kakor sparade och att dessa stämmer och inte blivit manipulerade hos klienten (förlängd utgångstid, samt ändring av värdet i kaka). 
	public function cookieLogin(){
	
		$usernameFromCookie = $this->view->getCookieUsername();
		$passwordFromCookie = $this->view->getCookiePassword();

		if($usernameFromCookie !== "" && $passwordFromCookie!== ""){
			 if($this->model->checkUserCredentials($usernameFromCookie,$passwordFromCookie)){ // Om värdet stämmer i kakorna. 
			 	
				$savedCookieTime = $this->model->getTime();
				$timeNow = time();
				$diffrenceInTime = $timeNow - $savedCookieTime;
				
				// Om skillnaden i tiden blir positiv så har längre tid gått än den ursprungliga utgångstiden för kakorna.  
				if($diffrenceInTime >= 0){
					return "Fel på cookies";
				}
			
				return "Inloggad med cookies";
			 }else{
			 	
			 	return "Fel på cookies";
			 }
		}
	}
	
	public function doLogin(){
		
		$this->model->sessionStart();
		
		// Ser till så att man som inloggad är skyddad mot sessionstöld i en annan typ av webbläsare. 
		if($this->model->session($this->view->getHttpUserAgent()) === false){
			$this->model->sessionDestroy();
			return $this->view->showLogin("");
		}
		
		$answer = $this->cookieLogin();
		
		if($answer === "Inloggad med cookies"){
			
			if($this->view->didUserPressLogout()){
				$this->view->deleteCookies();
				$this->model->sessionDestroy();
				return $this->view->showLogin("Du har nu loggat ut!");
			}
			
			return $this->view->showLoginSuccessful("Inloggad med cookies!");
			
		}else if($answer === "Fel på cookies"){
			$this->view->deleteCookies();
			$this->model->sessionDestroy();
			return $this->view->showLogin("Felaktig information i cookie");
	
		}else{ // Om inte inloggning mha kakor skett, hamnar man här. Kollar sedan om username finns sparat i $_SESSION. 
					
			if($this->model->checkIfLoggedIn()){
				
				if($this->view->didUserPressLogout()){
					$this->model->sessionDestroy();
					return $this->view->showLogin("Du har nu loggat ut!");
				}
				
				return $this->view->showLoginSuccessful("");
				
			}else{ // Om användaren väljer att logga in. Kontrollerar input i formuläret, och väljer efter resultatet vilket innehåll som skall returneras till HTMLView.
			
				if($this->view->didUserPressLogin()){
					$message = $this->view->controllInput();
					
					if($message === "Användarnamn och lösenord är angett"){
		
						if($this->model->checkUserCredentials($this->view->getInputUsername(),md5($this->view->getInputPassword()))){
							
							if($this->view->checkbox($this->model)){
							
								$this->model->addTime($this->view->getTime());
							
								return $this->view->showLoginSuccessful("Inloggningen lyckades och vi kommer ihåg dig till nästa gång");
								
							}else{
								return $this->view->showLoginSuccessful("Inloggningen lyckades");
							}
							
						}else{
							return $this->view->showLogin("Felaktigt användarnamn och/eller lösenord.");
						}
								
					}else{
						return $this->view->showLogin($message); 	
					}
				
				}else{ // Ej valt att logga in. 
					return $this->view->showLogin("");
				}    
			} 	
		}
	}
}
