<?
require "../inc/intro.php";
require "../inc/accesG.php"; 

// on vérifie la bonne saisie des champs obligatoires
if (strlen($_POST['nom'])<1) 	message_erreur('Veuillez remplir le champ "Nom"');
if (strlen($_POST['login'])<1) 	message_erreur('Veuillez remplir le champ "Identifiant"');
if (strlen($_POST['pass'])<1) 	message_erreur('Veuillez remplir le champ "Mot de passe"');

// on vérifie que ce login n'existe pas encore
$req="select * from comptes where login='".secure($_POST['login'])."'";
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
if ($ligne['id']!=$_POST['id']) message_erreur('Cet identifiant est déjà utilisé');

// on modifie ce compte dans la table "comptes"
$req="update comptes set ";
$req.="nom='".secure($_POST['nom'])."',";
$req.="prenom='".secure($_POST['prenom'])."',";
$req.="email='".secure($_POST['email'])."',";
$req.="tel='".secure($_POST['tel'])."',";
$req.="fonction='".secure($_POST['fonction'])."',";
$req.="login='".secure($_POST['login'])."',";
$req.="password='".secure($_POST['pass'])."' where id=".secure($_POST['id']);
$mysql_result = mysql_query($req,$connexion) ;

header("Location: comptes.php");
?>