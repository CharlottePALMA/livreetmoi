<?
require "../inc/intro.php";
require "../inc/accesG.php"; 

// suppression d'un compte
$req="delete from comptes where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;

header("Location: comptes.php");
?>
