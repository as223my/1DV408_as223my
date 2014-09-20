<?php

class HTMLView{

	public function echoHTML($content){
		
		if($content === NULL){
			throw new \Exception("HTMLView::echoHTML does not allow body to be null");
		}
			
		date_default_timezone_set("Europe/Stockholm");
		setlocale(LC_TIME, 'swedish');
		
		//%A = veckodag, %d = datum, %B = månad.
		$time = ucfirst(strftime("%A, den %d %B år %Y. Klockan är [%H:%M:%S]."));
			
		echo "
		<!DOCTYPE html>
		<html>
			<head>
			<title>Login</title>
			<meta charset ='utf-8' />
			</head>
			<body>
				$content
				<p>$time</p>
			</body>
		</html>";
	}
}
