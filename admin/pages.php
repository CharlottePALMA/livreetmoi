<?
require '../inc/intro.php';
require '../inc/accesG.php';


$req="select * from pages_categories order by ordre";
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result)) 
	$cat=$ligne['id'];
	
if (isset($_GET['cat'])) 
	$cat=secure($_GET['cat']);
else
if (isset($_SESSION['pcat'])) 
	$cat=secure($_SESSION['pcat']);

$_SESSION['pcat']=$cat;


if ($_POST['quoi']=="ajout")
	{
	// on vérifie la bonne saisie des champs obligatoires
	if (strlen(trim($_POST['titre']))<1) 	message_erreur('Veuillez remplir le champ "Titre"');
	
	$req="insert into pages ( `titre`, `categorie`, `etat`, `publi`, `ordre`,date) values (";
	$req.="'".secure(trim($_POST['titre']))."',";
	$req.="'".secure($_POST['categ'])."',";
	$req.="1,0,";
	$req.="'".time(NULL)."','".date("Y-m-d")."')";
	$mysql_result = mysql_query($req,$connexion) ;
	$id=mysql_insert_id();
	}

if ($_POST['quoi']=="modif")
	{
	// on vérifie la bonne saisie des champs obligatoires
	if (strlen(trim($_POST['titre']))<1) 	message_erreur('Veuillez remplir le champ "Titre"');
	
	$req="update pages set ";
	$req.="titre='".secure(trim($_POST['titre']))."',";
	$req.="texte='".secure(trim($_POST['texte']))."',";
	$req.="url='".secure(trim($_POST['url']))."',";
	$req.="date='".secure(datefr2en($_POST['date']))."',";
	$req.="categorie='".secure($_POST['categ'])."' ";
	$req.="where id=".secure($_POST['id']);
	$mysql_result = mysql_query($req,$connexion) ;
	
	
	$extension = strtolower(strrchr($_FILES["image"]['name'], '.')); 
	$image=charge_fichier("image","page_".time(NULL).rand(1,9999).$extension,5000000,array(".gif",".jpg",".png"));
	if (strlen($image)>0)
		{
		$req="update pages set ";
		$req.="image='".secure($image)."' ";
		$req.=" where id=".secure($_POST['id']);
		$mysql_result = mysql_query($req,$connexion) ;
		}
	else
	if ($_POST['delimage']==1)
		{
		$req="update pages set ";
		$req.="image='' ";
		$req.=" where id=".secure($_POST['id']);
		$mysql_result = mysql_query($req,$connexion) ;
		}
	
	}


if (isset($_POST['matable']))
	{
	foreach( $_POST['matable'] as $order => $id )
		{
			$req='UPDATE pages SET ordre = \'' . secure( $order ) . '\' WHERE id = \'' . secure( $id ) . '\'';
			$mysql_result = mysql_query($req,$connexion) ;
			echo $req."\n";
		}
	die();
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
              <td align="right" valign="middle"><div align="right" class="ttvert">Infos</div></td>
            </tr>
          </table>
          <br>
          <table width="690" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="middle">
<form method="get" action="pages.php">             
<select name="cat" onChange="javascript:submit();">
<?
$req="select * from pages_categories where etat<9 order by ordre";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$sel=""; if ($cat==$ligne['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne['id']?>" <?=$sel?>><?=$ligne['categorie']?></option>
    <?
	}
?>
</select>
</form>
              </td>
            </tr>
          </table>

<?
$tid="matable";
if ($cat==1) $tid="matab";

?>
          <br>
            <table width="690" border="0" cellspacing="0" cellpadding="5" id="<?=$tid?>">
              <tr class="pas_moi">
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Titre</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
              </tr>
<?
$cpt=0;
$req="select * from pages where etat<9 and categorie=".$cat." order by ordre";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$cpt++;
		
?>
              <tr id="matable_<?=$ligne['id']?>">
                <td align="left" valign="middle" class="fietbas"><div align="left"><a href="pages_mod.php?id=<?=$ligne['id']?>&v=1" class="lienorange"><?=$ligne['titre']?></a></div></td>
                <td align="center" valign="middle" class="fietbas">
<?
if ($ligne['image']!="")
	{
	?>
	<a href="/data/<?=$ligne['image']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$ligne['image'],100,50)?>"></a>
    <?
	}  
?>
				</td>
                <td align="center" valign="middle" class="fietbas">
<?              
	
$da=dateen2fr($ligne['date']);
if  ($ligne['date']=="0000-00-00") $da="&nbsp;";       

?>
				</td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$da?></div></td>
                <td align="center" valign="middle" class="fietbas">
<?
if ($ligne['publi']==0)
	{
	?>
    <a href="pages_publi.php?publi=1&id=<?=$ligne['id']?>"><img src="images/rouge.gif" border="0" title="Non publié. Cliquez pour la mettre en ligne."></a>
    <?
	}
else
	{
	?>
    <a href="pages_publi.php?publi=0&id=<?=$ligne['id']?>"><img src="images/vert.gif" border="0" title="En ligne. Cliquez pour ne plus la publier."></a>
    <?
	}
?>                
                </td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="pages_mod.php?id=<?=$ligne['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_page('<?=str_replace("'","\'", htmlspecialchars($ligne['libelle']))?>','<?=$ligne['id']?>');"><img src="images/bout_delete.gif" title="SUPPRIMER" width="18" height="18" border="0"></a></div></td>

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
                <td align="left" valign="middle" class="fietbas"><div align="left"class="ssttorange"><a href='javascript:swap_id("nouveau","slow");'>Nouvelle info</a></div></td>
              </tr>
          </table>
            <br>
            <br>
<form method="post" action="pages.php" id="nouveau" style="display:none">
<input type="hidden" name="quoi" value="ajout">
            <table width="690" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Catégorie</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="categ">
<?
$req="select * from pages_categories where etat<9 order by ordre";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$sel=""; if ($cat==$ligne['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne['id']?>" <?=$sel?>><?=$ligne['categorie']?></option>
    <?
	}
?>
                      </select>
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Titre</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="titre" type="text" class="txtfieldxlarge">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"></div></td>
                <td align="left" valign="middle"><div align="left"><input type="image" src="images/bout_valider.gif" alt="OK"  vspace="5" border="0"></div></td>
              </tr>
          </table></form>
            <p>&nbsp;</p>
        </div>        
        <p align="center"><br></p>        
        </td>
    </tr>
  </table>
<? require 'inc_bottom.php'; ?>
</div>
</body>
</html>
