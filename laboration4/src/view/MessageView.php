<?php
namespace view;

class MessageView{
	
	// Meddelanden, för att underlätta ändring av innehåll.
	public function errorNameMessage(){
		return "Användarnamnet har för få tecken. Minst 3 tecken.";
	}
	
	public function errorPasswordMessage(){
		return "Lösenordet har för få tecken. Minst 6 tecken.";
	}
	
	public function errorNoMatchPasswordMessage(){
		return "Lösenorden matchar inte.";
	}
	
	public function errorUserAlreadyExistMessage(){
		return "Användarnamnet är redan upptaget.";
	}
	
	public function errorTagInUsernameMessage(){
		return "Användarnamenet innehåller ogiltliga tecken"; 
	}
	
	public function newUserCreatedMessage(){
		return "Registrering av ny användare lyckades!"; 
	}
	
	// Message to functin doControll() in LoginController.
	
	public function LoggedInWithCookiesMessage(){
		return "Inloggning lyckades via cookies";
	}
	
	public function wrongInformationInCookieMessage(){
		
		return "Felaktig information i cookie";
	}
	
	public function loggedInWithCookiesFirstTimeMessage(){
		return "Inloggning lyckades och vi kommer ihåg dig nästa gång";
	}
	
	public function loggedInMessage(){
		return "Inloggningen lyckades";
	}
	
	public function usernameMissingMessage(){
		return "Användarnamn saknas";
	}
	
	public function passwordMissingMessage(){
		return "Lösenord saknas";
	}
	
	public function wrongInputMessage(){
		return "Felaktigt användarnamn och/eller lösenord";
	}
}
