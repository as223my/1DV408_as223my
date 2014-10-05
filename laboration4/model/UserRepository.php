<?php
namespace model;

require_once ("src/model/Repository.php");

class UserRepository extends base\Repository {
	
	private static $userID = "userID"; 
	private static $password = "password";
	private static $name = "name";
	private $table = "Login";
	
	// lägger till användaren i databasen.
	public function create(User $user) {
		try{
		    
			$db = $this->connection();
			$sql = "INSERT INTO $this->table(" . self::$userID. ", " . self::$name . ", " . self::$password . " ) VALUES (?, ?, ?)";
			
			$params = array("",$user->getUserName(), $user->getPassword());

			$query = $db->prepare($sql);
			$query->execute($params);
			
		}catch(\PDOException $e){
			die('An unknown error have occured.');
		}
	}
	
	// Kollar om användarnamet redan finns i databasen, vid registrering.
	public function checkIfExist(User $user){
	    try{
	    
	    $db = $this -> connection();
		$sql = "SELECT ". self::$name ." FROM $this->table";
		
		$query = $db -> prepare($sql);
		$query->execute();
		
		foreach ($query->fetchAll() as $result){
			foreach ($result as $key => $value){
				if($key === self::$name){
    				if($value === $user->getUserName()){
    					return true;
    				}
    			}
			}
		}
	    return false;
	    
	}catch(\PDOException $e){
			die('An unknown error have occured.');
		}
	}

    // Kollar så att användarnamn och lösenord stämmer med informationen i databasen.
	public function checkBeforeLogin($name, $password){
	try{
	    
	    $newPassword = md5($password); 
	    $db = $this->connection();
	    
	    $sql = "SELECT * FROM $this->table WHERE " . self::$password . " = ?";
		$params = array($newPassword);
		
		$query = $db->prepare($sql);
		$query->execute($params);
		
		foreach ($query->fetchAll() as $result){
			foreach ($result as $key => $value){
				if($key === self::$name){
				    
    				if($value === $name){
    				    return true;
    				}
    			}
			}
		}
		return false;
		
	}catch(\PDOException $e){
			die('An unknown error have occured.');
		}
	}
}
