<?php

require 'inc/intro.php';

$email=trim($_POST['email']);
$pass=trim($_POST['pass']);

if (strlen($email)<5) message("Veuillez saisir une adresse e-mail valide");
if (strstr($email,"@")==NULL) message("Veuillez saisir une adresse e-mail valide");
if (strstr($email,".")==NULL) message("Veuillez saisir une adresse e-mail valide");

if (strlen($pass)<6) message("Le mot de passe doit avoir au moins 6 caractères");

$req="select * from utilisateurs where email='".secure($email)."' and pass='".secure($pass)."' ";
$mysql_result = mysql_query($req,$connexion) ;
if (!$ligne = mysql_fetch_array($mysql_result))
	{
	message("Mauvaise adresse e-mail et/ou mot de passe");
	}
	

$id=$ligne['id'];


// on recherche la date de dernière connexion
$last="";
$req="select * from logs_users where idlogin=".$ligne['id']." order by id desc";	
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
	{
	$d1=substr($ligne['date'],0,10);
	$d2=substr($ligne['date'],11,5);
	
	$a=substr($d1,0,4); $m=substr($d1,5,2); $j=substr($d1,8,2);
	$last="Derni&egrave;re connection le <b>".$j."/".$m."/".$a."</b> &agrave; <b>".$d2."</b>";
	}


// on ajoute dans la table "logs" la trace de cette connexion
$req="insert into logs_users (date,idlogin) values ('".date("Y-m-d H:i")."',".$id.")";
$mysql_result = mysql_query($req,$connexion) ;



$_SESSION['user']=$id;
$_SESSION['prenom']=$prenom;
$_SESSION['email']=$email;
$_SESSION['last']=$last;

header("Location: /index.php?a=".time(NULL));
?>