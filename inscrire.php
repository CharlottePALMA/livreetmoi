<?php

require 'inc/intro.php';

$email=trim($_POST['email']);
$pass=trim($_POST['pass']);
$prenom=trim($_POST['prenom']);

if (strlen($email)<5) message("Veuillez saisir une adresse e-mail valide");
if (strstr($email,"@")==NULL) message("Veuillez saisir une adresse e-mail valide");
if (strstr($email,".")==NULL) message("Veuillez saisir une adresse e-mail valide");

if (strlen($pass)<6) message("Le mot de passe doit avoir au moins 6 caractères");
if (strlen($prenom)<1) message("Veuillez saisir votre prénom");

$req="select * from utilisateurs where email='".secure($email)."' ";
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
	{
	message("Il existe déjà un compte avec cette adresse e-mail");
	}
	
	
$req="insert into utilisateurs (email,prenom,pass) values(";
$req.="'".secure($email)."', ";	
$req.="'".secure($prenom)."', ";	
$req.="'".secure($pass)."') ";	
$mysql_result = mysql_query($req,$connexion) ;

$id=mysql_insert_id();

$_SESSION['user']=$id;
$_SESSION['prenom']=$prenom;
$_SESSION['email']=$email;

header("Location: index.php#COMPTE");
?>