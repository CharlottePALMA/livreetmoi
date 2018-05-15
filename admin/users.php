<?
require '../inc/intro.php';
require '../inc/accesG.php';



if ($_GET['del']>0)
	{
	// suppression d'un compte
	$req="delete from auteurs where id=".secure($_GET['del']);
	$mysql_result = mysql_query($req,$connexion) ;
	}
	
if (isset($_GET['publi']))
	{
	$req="update auteurs set ";
	$req.="publi=".mysql_real_escape_string(stripslashes($_GET['publi']));
	$req.=" where id=".mysql_real_escape_string(stripslashes($_GET['id']));
	$mysql_result = mysql_query($req,$connexion) ;
	}


if ($_POST['quoi']=="modif")
	{
	// on vérifie la bonne saisie des champs obligatoires
	if (strlen(trim($_POST['nom']))<1) 	message_erreur('Veuillez remplir le champ "Nom"');
	
	if ($_POST['id']==0)
		{
		$req="insert into auteurs ( `nom`,prenom,bio) values (";
		$req.="'".secure(trim($_POST['nom']))."',";
		$req.="'".secure(trim($_POST['prenom']))."',";
		$req.="'".secure(trim($_POST['bio']))."')";
		$mysql_result = mysql_query($req,$connexion) ;
		$id=mysql_insert_id();
		$_POST['id']=$id;
		}
	
	$req="update auteurs set ";
	$req.="nom='".secure(trim($_POST['nom']))."', ";
	$req.="prenom='".secure(trim($_POST['prenom']))."', ";
	$req.="bio='".secure(trim($_POST['bio']))."' ";
	$req.="where id=".secure($_POST['id']);
	$mysql_result = mysql_query($req,$connexion) ;
	
	
	$extension = strtolower(strrchr($_FILES["image"]['name'], '.')); 
	$image=charge_fichier("image","photo_auteur_".time(NULL).rand(1,9999).$extension,5000000,array(".gif",".jpg",".png",".jpeg"));
	if (strlen($image)>0)
		{
		$req="update auteurs set ";
		$req.="photo='".secure($image)."' ";
		$req.=" where id=".secure($_POST['id']);
		$mysql_result = mysql_query($req,$connexion) ;
		}
	else
	if ($_POST['delimage']==1)
		{
		$req="update auteurs set ";
		$req.="photo='' ";
		$req.=" where id=".secure($_POST['id']);
		$mysql_result = mysql_query($req,$connexion) ;
		}
	
	}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$titre_principal?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<? require 'inc_meta.php'; ?>


<script>
$(document).ready( function(){ // quand la page a fini de se charger

  $("#matable").sortable({ // initialisation de Sortable sur #list-photos
	items: "tr:not(.pas_moi)",
	placeholder: 'highlight', // classe à ajouter à l'élément fantome
	update: function() {  // callback quand l'ordre de la liste est changé
		var order = $('#matable').sortable('serialize'); // récupération des données à envoyer
		$.post('pages.php',order); // appel ajax au fichier ajax.php avec l'ordre des photos
	}
  });
  $("#matable").disableSelection(); // on désactive la possibilité au navigateur de faire des sélections

});
</script>

</head>

<body>
<div align="center"><? require 'inc_top.php'; ?>
<table width="963" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="200" align="left" valign="top" class="fietD"><div align="left">
		<br>
		<? require 'inc_menu.php'; ?>
		<br>
      </div>
      </td>
      <td align="center" valign="top" class="filetleftrightbottom">        
        <div align="center"><br>
          <br>
          <table width="690" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right" valign="middle"><div align="right" class="ttvert">Utilisateurs</div></td>
            </tr>
          </table>
          <br>
          <?
$tid="matableZ";

?>
          <br>
            <table width="690" border="0" cellspacing="0" cellpadding="5" id="<?=$tid?>">
              <tr class="pas_moi">
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Nom</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
              </tr>
<?
$cpt=0;
$req="select * from utilisateurs order by prenom";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$cpt++;

	// on recherche la date de dernière connexion
	$last="";
	$req="select * from logs_users where idlogin=".$ligne['id']." order by id desc";	
	$mysql_result2 = mysql_query($req,$connexion) ;
	if ($ligne2 = mysql_fetch_array($mysql_result2))
		{
		$d1=substr($ligne2['date'],0,10);
		$d2=substr($ligne2['date'],11,5);
		
		$a=substr($d1,0,4); $m=substr($d1,5,2); $j=substr($d1,8,2);
		$last="Derni&egrave;re connection le <b>".$j."/".$m."/".$a."</b> &agrave; <b>".$d2."</b>";
		}

		
?>
              <tr id="matable_<?=$ligne['id']?>">
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$ligne['prenom']?><br><?=$ligne['email']?></div></td>
                <td align="center" valign="middle" class="fietbas">
<?
if ($ligne['avatar']!="")
	{
	?>
	<a href="/data/<?=$ligne['avatar']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$ligne['avatar'],100,50)?>"></a>
    <?
	}  
?>
				</td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=dateen2fr($ligne['dateNaissance'])?></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$ligne['ville']?><br><?=$ligne['pays']?></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$last?></div></td>
              </tr>
<?
	}
?>              
          </table>
            <br>
        </div>        
        <div align="center"><br>
          <br>
            <br>
        </div>        
        </td>
    </tr>
  </table>
<? require 'inc_bottom.php'; ?>
</div>
</body>
</html>
