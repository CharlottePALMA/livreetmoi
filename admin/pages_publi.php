<?
require "../inc/intro.php";
require "../inc/accesG.php"; 

$req="update pages set ";
$req.="publi=".mysql_real_escape_string(stripslashes($_GET['publi']));
$req.=" where id=".mysql_real_escape_string(stripslashes($_GET['id']));
$mysql_result = mysql_query($req,$connexion) ;


echo '<meta HTTP-EQUIV="Refresh" CONTENT="0;URL=pages.php">';
?>
