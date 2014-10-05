<?php
namespace model\base;

class Repository{
    
    // Connecta mot databsen.
	protected $dbUsername = 'anniesahlberg_s';
	protected $dbPassword = 'zTHTAwfS';
	protected $dbConnstring = 'mysql:host=anniesahlberg.se.mysql;dbname=anniesahlberg_s';
	protected $dbConnection;
	
	protected function connection(){
	    
		if ($this->dbConnection == NULL){
	    	$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
	    	
		}else{
			$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		
		return $this->dbConnection;
	}
}
