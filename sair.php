<?php
require_once("./authSession.php");

	$_SESSION = array();  //Limpa o vetor de sessão

	
	if (ini_get("session.use_cookies")) {					
		$params = session_get_cookie_params();				
		setcookie(session_name(), '', time() - 42000,		
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	
	setcookie('loginautomatico', '', time() - 42000); //apaga o cookie que contém a senha		
	
}
	session_destroy();		
header("Location: ./index.php");	
?>
