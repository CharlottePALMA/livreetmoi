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
if ($ligne = mysql_fetch_array($mysql_result)) message_erreur('Cet identifiant est déjà utilisé');

// on ajoute ce compte dans la table "comptes"
$req="insert into comptes (nom,prenom,login,password) values (";
$req.="'".secure($_POST['nom'])."',";
$req.="'".secure($_POST['prenom'])."',";
$req.="'".secure($_POST['login'])."',";
$req.="'".secure($_POST['pass'])."')";
$mysql_result = mysql_query($req,$connexion) ;


header("Location: comptes.php");
?>
