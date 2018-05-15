<?php

require 'inc/intro.php';

$pass=trim($_POST['pass']);
$prenom=trim($_POST['prenom']);

if (strlen($pass)<6) message("Le mot de passe doit avoir au moins 6 caractères");
if (strlen($prenom)<1) message("Veuillez saisir votre prénom");


$req="update utilisateurs set ";
$req.="prenom='".secure(trim($_POST['prenom']))."', ";
$req.="ville='".secure(trim($_POST['ville']))."', ";
$req.="pays='".secure(trim($_POST['pays']))."', ";
$req.="dateNaissance='".secure(trim(datefr2en($_POST['ddn'])))."', ";
$req.="pass='".secure(trim($_POST['pass']))."' ";
$req.="where id=".secure($_SESSION['user']);
$mysql_result = mysql_query($req,$connexion) ;


$extension = strtolower(strrchr($_FILES["image"]['name'], '.')); 
$image=charge_fichier("image","avatar_".time(NULL).rand(1,9999).$extension,5000000,array(".gif",".jpg",".png",".jpeg"));
if (strlen($image)>0)
	{
	$req="update utilisateurs set ";
	$req.="avatar='".secure($image)."' ";
	$req.=" where id=".secure($_SESSION['user']);
	$mysql_result = mysql_query($req,$connexion) ;
	}
else
if ($_POST['delimage']==1)
	{
	$req="update utilisateurs set ";
	$req.="avatar='' ";
	$req.=" where id=".secure($_SESSION['user']);
	$mysql_result = mysql_query($req,$connexion) ;
	}


header("Location: /index.php?maj=1&a=".time(NULL)."#compte");
?>