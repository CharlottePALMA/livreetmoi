<?php  

/////////////////////////////////////////////////////////////
// connexion à la base de données
$hote="127.0.0.1";
$utilisateur="root";
$password="guirbaden";
$connexion = mysql_connect($hote,$utilisateur,$password);
if ($connexion<=0) 
	{ 
	}
mysql_select_db('livres',$connexion);
mysql_query("SET NAMES 'utf8'"); 

$yves=0;
if ($_SERVER['REMOTE_ADDR']=="193.252.57.43") $yves=1;

//
/////////////////////////////////////////////////////////////


?>
