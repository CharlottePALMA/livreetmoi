<?
require '../inc/intro.php';


$req="select * from comptes where login='".secure($_POST['login'])."' and password='".secure($_POST['pass'])."'";
$mysql_result = mysql_query($req,$connexion) ;
if (!$ligne = mysql_fetch_array($mysql_result))
	{
	// aucune ligne dans la table avec ce login et ce mot de passe
	header("Location: log.php?ko=1");
	exit;
	}
	
	
$id=$ligne['id'];

$_SESSION['admin']=$ligne['prenom']." ".$ligne['nom'];
$_SESSION['idadmin']=$ligne['id'];
$_SESSION['email']=$ligne['email'];
$_SESSION['login']=$ligne['login'];



// on recherche la date de dernière connexion
$last="";
$req="select * from logs where idlogin=".$ligne['id']." order by id desc";	
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
	{
	$d1=substr($ligne['date'],0,10);
	$d2=substr($ligne['date'],11,5);
	
	$a=substr($d1,0,4); $m=substr($d1,5,2); $j=substr($d1,8,2);
	$last=" | Derni&egrave;re connection le <b>".$j."/".$m."/".$a."</b> &agrave; <b>".$d2."</b>";
	}


// on ajoute dans la table "logs" la trace de cette connexion
$req="insert into logs (date,idlogin) values ('".date("Y-m-d H:i")."',".$id.")";
$mysql_result = mysql_query($req,$connexion) ;


$phrase="Bienvenue <b>".$_SESSION['admin']."</b>".$last;

$_SESSION['phrase_admin']=$phrase;

// on va se connecter sur le forum


echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=livres.php">';

?>
