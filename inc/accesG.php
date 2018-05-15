<?php  

// si on n'est pas connecté ou si la session a expirée, on affiche la mire de login

if (!isset($_SESSION['admin']))
	header("Location: /admin/log.php");

?>