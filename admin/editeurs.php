<?
require '../inc/intro.php';
require '../inc/accesG.php';



if ($_GET['del']>0)
	{
	// suppression d'un compte
	$req="delete from editeurs where id=".secure($_GET['del']);
	$mysql_result = mysql_query($req,$connexion) ;
	}
	
if (isset($_GET['publi']))
	{
	$req="update editeurs set ";
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
		$req="insert into editeurs ( `nom`) values (";
		$req.="'".secure(trim($_POST['nom']))."')";
		$mysql_result = mysql_query($req,$connexion) ;
		$id=mysql_insert_id();
		$_POST['id']=$id;
		}
	
	$req="update editeurs set ";
	$req.="nom='".secure(trim($_POST['nom']))."' ";
	$req.="where id=".secure($_POST['id']);
	$mysql_result = mysql_query($req,$connexion) ;
	
	
	$extension = strtolower(strrchr($_FILES["image"]['name'], '.')); 
	$image=charge_fichier("image","logo_editeur_".time(NULL).rand(1,9999).$extension,5000000,array(".gif",".jpg",".png"));
	if (strlen($image)>0)
		{
		$req="update editeurs set ";
		$req.="logo='".secure($image)."' ";
		$req.=" where id=".secure($_POST['id']);
		$mysql_result = mysql_query($req,$connexion) ;
		}
	else
	if ($_POST['delimage']==1)
		{
		$req="update editeurs set ";
		$req.="logo='' ";
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
/*
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
*/
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
              <td align="right" valign="middle"><div align="right" class="ttvert">Editeurs</div></td>
            </tr>
          </table>
          <br>
          <?
$tid="matableZ";

?>
          <br>
            <table width="690" border="0" cellspacing="0" cellpadding="5" id="<?=$tid?>">
              <tr class="pas_moi">
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Editeur</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
              </tr>
<?
$cpt=0;
$req="select * from editeurs order by nom";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$cpt++;
		
?>
              <tr id="matable_<?=$ligne['id']?>">
                <td align="left" valign="middle" class="fietbas"><div align="left"><a href="editeurs_mod.php?id=<?=$ligne['id']?>&v=1" class="lienorange"><?=$ligne['nom']?></a></div></td>
                <td align="center" valign="middle" class="fietbas">
<?
if ($ligne['logo']!="")
	{
	?>
	<a href="/data/<?=$ligne['logo']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$ligne['logo'],100,50)?>"></a>
    <?
	}  
?>
				</td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="editeurs_mod.php?id=<?=$ligne['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_editeur('<?=str_replace("'","\'", htmlspecialchars($ligne['nom']))?>','<?=$ligne['id']?>');"><img src="images/bout_delete.gif" title="SUPPRIMER" width="18" height="18" border="0"></a></div></td>

              </tr>
<?
	}
?>              
          </table>
            <br>
        </div>        
        <div align="center"><br>
            <br>
            <table width="690" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="fietbas"><div align="left"class="ssttorange"><a href="editeurs_mod.php?id=0">Nouvel éditeur</a></div></td>
              </tr>
          </table>
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
