<?php
namespace model;

class User{
	
	private $name;
	private $password1;
	private $tag; 
	
	// validerar användarnamnet vid login. 
	public function name($input){ 
	    $checkedName = $this->checkForTags($input);
	    
		if(strlen($input) >= 3){
			$this->name = $checkedName;
			return true;
			
		}else{
			return false;
		}
	}
	
	// validerar lösenordet vid login. 
	public function password($input){
	    
		if(strlen($input) >= 6){
			$this->password1 = $input;
			return true;
			
		}else{
			return false;
		}		
	}
	
	// kollar så att båda lösenorden matchar. 
	public function checkIfPasswordMatch($password2){
	    
		if($this->password1 === $password2){
			return true;
			
		}else{
			return false;
		}
		
	}
	
	// kollar efter html-kod (tags).
	public function checkForTags($name){
		
		if(strip_tags($name) === $name){
			$this->tag = false;
			return $name; 
			
		}else{
			$this->tag = true;
			return strip_tags($name);
		}
	}
		
	public function tagInName(){
	    
		if($this->tag === true){
			return true;
		}
	    return false;
	}
		
	public function getUserName(){
		return $this->name;
	}
	
	public function getPassword(){
		$md5Password = md5($this->password1);
		return $md5Password;
	}
}
