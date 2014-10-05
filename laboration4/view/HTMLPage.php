<?php
namespace view;

class HTMLPage{

	public function getPage($body){
		if ($body === NULL) {
			throw new \Exception("HTMLView::echoHTML does not allow body to be NULL");
		}
		echo
			"<!DOCTYPE html>
			<html>
				<head>
					<title>Login</title>
					<meta charset=utf-8>
				</head>
				<body>
					 $body
				</body>
			</html>";
	}
}
