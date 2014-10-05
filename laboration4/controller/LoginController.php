<?php
namespace controller;

require_once("src/view/LoginView.php");
require_once("src/model/LoginModel.php");
require_once("src/view/LoginCookieView.php");

require_once("src/view/RegisterView.php");
require_once("src/view/MessageView.php");
require_once("src/model/User.php");
require_once("src/model/UserRepository.php");


class LoginController {

	private $loginView;
	private $loginCookieView;
	private $loginModel;
	
	private $registerView; 
	private $user;
	private $userRepository;
	private $messageView;

	public function __construct(){
		$this->loginView = new \view\LoginView();
		$this->loginCookieView = new \view\LoginCookieView();
		$this->loginModel = new \model\LoginModel();
		
		$this->registerView = new \view\RegisterView();
		$this->messageView = new \view\MessageView();
		$this->user = new \model\User();
		$this->userRepository = new \model\UserRepository();
	}
	
	// sköter registreringen av nu användare. 
	public function registration(){
	
	    //Förtydligande variablar, lättare att ändra. 
		$name = $this->registerView->getName(); 
		$password1 = $this->registerView->getPassword1();
		$password2 = $this->registerView->getPassword2();
				
		$errorName = $this->messageView->errorNameMessage();
		$errorPassword = $this->messageView->errorPasswordMessage();
		$errorNoMatchPassword = $this->messageView->errorNoMatchPasswordMessage();
		$errorUsernameExist = $this->messageView->errorUserAlreadyExistMessage(); 
		$errorTagInUsername = $this->messageView->errorTagInUsernameMessage(); 
		$newUserCreated = $this->messageView->newUserCreatedMessage();
		
		// validering av användarnamn och lösenord.  
		if($this->user->name($name) === true && $this->user->password($password1) === true){ 
		    
			if(!$this->user->checkIfPasswordMatch($password2)){ // kollar om lösenorden matchar varandra. 
				return $this->registerView->doRegisterView("",$errorNoMatchPassword, $name);
				
			}else{
			    
			    if($this->userRepository->checkIfExist($this->user)){ // kollar om användarnamn finns ledigt. 
					return $this->registerView->doRegisterView($errorUsernameExist,"",$name);
				}
							
				if($this->user->tagInName()){ // kollar efter tags i användarnamnet, tar bort eventuella tags. 
					return $this->registerView->doRegisterView($errorTagInUsername,"",$this->user->getUserName());
				}
							
				$this->userRepository->create($this->user); // användarens uppgifter är godkända, lägger till användare i databasen.
				return $this->loginView->doLoginPage($newUserCreated);
		    }
		    
		}else{
		    
			if($this->user->name($name) === true && $this->user->password($password1) === false){ // lösenordet går inte igenom valideringen.
				return $this->registerView->doRegisterView("",$errorPassword, $name);
			}
				
			if($this->user->name($name) === false && $this->user->password($password1) === true){ // användarnamnet går inte igenom valideringen.
				return $this->registerView->doRegisterView($errorName,"",$name);
			}
			
			return $this->registerView->doRegisterView($errorName,$errorPassword,$name); // varken användarnamnet eller lösenordet går igenom valideringen.
		}
	}

	public function doControll(){
	    
		//Meddelande för utskrift (skickas med till LoginView). 
		$loggedIn = $this->messageView->loggedInMessage();
		$usernameMissing = $this->messageView->usernameMissingMessage();
		$passwordMissing = $this->messageView->passwordMissingMessage();
		$wrongInput = $this->messageView->wrongInputMessage();
			
		$loggedInWithCookiesFirstTime = $this->messageView->loggedInWithCookiesFirstTimeMessage();
		$loggedInWithCookies = $this->messageView->loggedInWithCookiesMessage();
		$wrongInformationInCookie = $this->messageView->wrongInformationInCookieMessage();

		// Om man klickat på Registrera ny användare i Login.	
		if($this->loginView->register()){
			return $this->registerView->doRegisterView("","","");
		}
			
		// Om man väljer registrera i registreringsformuläret. 
		if($this->loginView->registerNewUser()){
				return $this->registration();
		}


		//hantering loginscenarion
		if ($this->loginView->triedToLogout()){
                $messages = $this->loginModel->doLogout($this->loginView->getClientIdentifier());
				$this->loginModel->removeClientIdentifier($this->loginCookieView->getCookieName());
				$this->loginCookieView->removeCookie();
				
				return $this->loginView->doLoginPage($messages);
		}
			
		//scenario - användaren är redan inloggad, via cookies.
		if ($this->loginCookieView->getCookieName() != null && $this->loginCookieView->getCoookiePassword() != null){
		
			//säkerhetskontroll, tid cookies. 
			if(!$this->loginCookieView->checkTime()){
				    
				$this->loginCookieView->removeCookie();
				if(!$this->loginModel->isLoggedIn()){
				    
					return $this->loginView->doLoginPage($wrongInformationInCookie);
				}
				
				$name = $this->loginModel->getSessionName();
				return $this->loginView->loggedInPage($name,"");
			}
				
			$stringToVerify = $this->loginCookieView->pickupCookieInformation($this->loginCookieView->getCoookiePassword());
				
			//jämför strängen mot dem i filen
			if($this->loginModel->cookieSecurityCheck($stringToVerify)){
				
				if($this->loginView->triedToLogout()){
					$this->loginModel->removeClientIdentifier($this->loginCookieView->getCookieName());
					$this->loginCookieView->removeCookie();
					$messages = $this->loginModel->doLogout();
					
					return $this->loginView->doLoginPage($messages);
				}
				
				$name = $this->loginCookieView->getCookieName();
				return $this->loginView->loggedInPage($name,$loggedInWithCookies);
			}else{
				$this->loginCookieView->removeCookie();
				$this->loginModel->doLogout($this->loginView->getClientIdentifier());
				
				return $this->loginView->doLoginPage($wrongInformationInCookie);
				
			}
		}else if($this->loginModel->isLoggedIn()){ // inloggad via session
		
			//säkerhetskontroll
			if($this->loginModel->cookieSecurityCheck($this->loginView->getClientIdentifier())){
			    
				if ($this->loginView->triedToLogout()){
				    $messages = $this->loginModel->doLogout($this->loginView->getClientIdentifier());
					return $this->loginView->doLoginPage($messages);
					
				}
				
				$name = $this->loginModel->getSessionName();
				return  $this->loginView->loggedInPage($name, "");
			}else{
				return $this->loginView->doLoginPage("");
				
			}
			
		}else{ //scenario - användaren är inte inloggad
	                
			// användaren har tryck på "Logga in"
			if ($this->loginView->triedToLogin()){
				   
				//kontroll av inloggningsuppgifter
				if($this->loginModel->doLogin($this->loginView->getName(), $this->loginView->getPassword())){
					     
					//om användaren kryssat i "håll mig inloggad"
					if($this->loginView->checkBox()){
					   
					    $encryptedPassword = $this->loginCookieView->encryptPassword($this->loginView->getPassword());
						$this->loginCookieView->createCookie($this->loginView->getName(), $encryptedPassword);
						$cookieUnique = $this->loginCookieView->pickupCookieInformation($encryptedPassword);
						$this->loginModel->saveToFile($cookieUnique);
						
						$name = $this->loginCookieView->getCookieName();
						return $this->loginView->loggedInPage($name,$loggedInWithCookiesFirstTime);
						
					}else{ //inloggning utan ikryssad ruta
					
						$name = $this->loginModel->getSessionName();
						return $this->loginView->loggedInPage($name, $loggedIn);
					}
				}else{
			
					if(!$this->loginView->getName()){
						  return $this->loginView->doLoginPage($usernameMissing);
						  
					}else if(!$this->loginView->getPassword()){
						   return $this->loginView->doLoginPage($passwordMissing);
						   
					}else{
						return $this->loginView->doLoginPage($wrongInput);
					}
						
				}
			} 
		}
		
		//scenario - användaren är nu inloggad
		if ($this->loginModel->isLoggedIn()){
		    
			//Säkerhetskontroll för att undvika sessionsstöld
			if($this->loginModel->cookieSecurityCheck($this->loginView->getClientIdentifier())){
				$this->loginModel->isLoggedIn();
				$name = $this->loginModel->getSessionName();
				
				return $this->loginView->loggedInPage($name,"");
			}else{
				return $this->loginView->doLoginPage("");
			}
		}
		
	return $this->loginView->doLoginPage("");
	
	}
}
