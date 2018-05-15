<?
require "../inc/intro.php";
require "../inc/accesG.php"; 

// suppression d'un compte
$req="update pages set etat=9 where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;

header("Location: pages.php");
?>
