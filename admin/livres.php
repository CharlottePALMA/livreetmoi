<?
require '../inc/intro.php';
require '../inc/accesG.php';

$idauteur=0;
	
if (isset($_GET['idauteur'])) 
	$idauteur=secure($_GET['idauteur']);
else
if (isset($_SESSION['idauteur'])) 
	$idauteur=secure($_SESSION['idauteur']);

$_SESSION['idauteur']=$idauteur;


if ($_GET['del']>0)
	{
	// suppression d'un compte
	$req="delete from livres where id=".secure($_GET['del']);
	$mysql_result = mysql_query($req,$connexion) ;
	}
	
if (isset($_GET['publi']))
	{
	$req="update livres set ";
	$req.="publi=".mysql_real_escape_string(stripslashes($_GET['publi']));
	$req.=" where id=".mysql_real_escape_string(stripslashes($_GET['id']));
	$mysql_result = mysql_query($req,$connexion) ;
	}

if ($_POST['quoi']=="notes")
	{
	$req="select * from questions ";
	$mysql_result = mysql_query($req,$connexion) ;
	while ($ligne = mysql_fetch_array($mysql_result)) 
		{
		for ($i=1;$i<=15;$i++)
			{
			$req="delete from livres_reponses where idLivre=".secure($_POST['id'])." and idQuestion=".$ligne['id']." and idReponse=".$i;
			$mysql_result2 = mysql_query($req,$connexion) ;
			if ($_POST['CK'.$ligne['id'].'_'.$i]>0)
				{
				$req="insert into livres_reponses (idLivre,idQuestion,idReponse,note) values (";
				$req.="'".secure($_POST['id'])."', ";
				$req.="'".secure($ligne['id'])."', ";
				$req.="'".secure($i)."', ";
				$req.="'".secure($_POST['CK'.$ligne['id'].'_'.$i])."') ";
				$mysql_result2 = mysql_query($req,$connexion) ;
				}
			}
		}
	}



if ($_POST['quoi']=="modif")
	{
	// on vérifie la bonne saisie des champs obligatoires
	if (strlen(trim($_POST['titre']))<1) 	message_erreur('Veuillez remplir le champ "Titre"');

	if ($_POST['id']==0)
		{
		$req="insert into livres ( `titre`) values (";
		$req.="'".secure(trim($_POST['titre']))."')";
		$mysql_result = mysql_query($req,$connexion) ;
		$id=mysql_insert_id();
		$_POST['id']=$id;
		}
	
	if (strstr($_POST['lien_fnac'],"#")!=NULL)
		{
		$i=strpos($_POST['lien_fnac'],"#");
		$_POST['lien_fnac']=substr($_POST['lien_fnac'],0,$i);
		}
	
	$req="update livres set ";
	$req.="titre='".secure(trim($_POST['titre']))."',";
	$req.="sousTitre='".secure(trim($_POST['sousTitre']))."',";
	$req.="tome='".secure(trim($_POST['tome']))."',";
	$req.="idEditeur='".secure($_POST['idEditeur'])."',";
	$req.="resume='".secure($_POST['resume'])."',";
	$req.="prix='".secure($_POST['prix'])."',";
	$req.="nbPage='".secure($_POST['nbPage'])."',";
	$req.="nbChapitres='".secure($_POST['nbChapitres'])."',";
	$req.="lien_fnac='".secure($_POST['lien_fnac'])."',";
	$req.="idAuteur='".secure($_POST['idAuteur'])."',";
	$req.="tpsLecture='".secure($_POST['tpsLecture'])."',";
	$req.="collection='".secure($_POST['collection'])."' ";
	$req.="where id=".secure($_POST['id']);
	$mysql_result = mysql_query($req,$connexion) ;
	
	
	$extension = strtolower(strrchr($_FILES["image"]['name'], '.')); 
	$image=charge_fichier("image","couverture_".time(NULL).rand(1,9999).$extension,5000000,array(".gif",".jpg",".png"));
	if (strlen($image)>0)
		{
		$req="update livres set ";
		$req.="couverture='".secure($image)."' ";
		$req.=" where id=".secure($_POST['id']);
		$mysql_result = mysql_query($req,$connexion) ;
		}
	else
	if ($_POST['delimage']==1)
		{
		$req="update livres set ";
		$req.="couverture='' ";
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



function filtre()
{
nom1=document.getElementById("FNOM1").value.toLowerCase();

for (i=1;i<10000;i++)
	{
	ob=document.getElementById("LGNOM1"+i);
	if (ob)
		{
		nom11=document.getElementById("LGNOM1"+i).value.toLowerCase();	
		nom22=document.getElementById("LGNOM2"+i).value;	
		ob=document.getElementById(nom22);

		ok=1;
		if (nom1.length>0)		{ j=nom11.indexOf(nom1); if (j<0) ok=0; if (nom11.length==0) ok=0;	}
			
		if (ok==1)
			ob.style.display="";
		else
			ob.style.display="none";

		}
	else
		i=100000;
	}
}

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
              <td align="right" valign="middle"><div align="right" class="ttvert">Livres</div></td>
            </tr>
          </table>
<br>
<table width="690" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="middle" style="width:150px;">
<form method="get" action="livres.php">             
<select name="idauteur" onChange="javascript:submit();">
<option value="0">Tous les auteurs</option>
<?
$req="select * from auteurs order by nom,prenom";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$sel=""; if ($idauteur==$ligne['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne['id']?>" <?=$sel?>><?=$ligne['nom']?> <?=$ligne['prenom']?></option>
    <?
	}
?>
</select>
</form>
</td>
<td>&nbsp;</td>
<td align="left">Filtre : 
<input type="text" name="filtre" id="FNOM1" onKeyUp="javascript:filtre();">
              </td>
            </tr>
          </table>
          <br>
          <?
$tid="matableZ";

?>
          <br>
            <table width="690" border="0" cellspacing="0" cellpadding="5" id="<?=$tid?>">
              <tr class="pas_moi">
                <td width="20" align="left" valign="middle" class="fietbas">&nbsp;</td>
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Titre</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier"></b></div></td>
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Auteur</b></div></td>
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Editeur</b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas">&nbsp;</td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
              </tr>
<?
$cpt=0;
$req="select * from livres ";
if ($idauteur>0)
$req.=" where idAuteur=".secure($idauteur);
$req.=" order by titre";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$cpt++;

	$req="select * from auteurs where id=".$ligne['idAuteur'];
	$mysql_result2 = mysql_query($req,$connexion) ;
	$aut = mysql_fetch_array($mysql_result2);

	$req="select * from editeurs where id=".$ligne['idEditeur'];
	$mysql_result2 = mysql_query($req,$connexion) ;
	$edi = mysql_fetch_array($mysql_result2);

		
?>
              <tr id="matable_<?=$ligne['id']?>">
                <td align="center" valign="middle" class="fietbas"><?=$cpt?></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><a href="livres_mod.php?id=<?=$ligne['id']?>&v=1" class="lienorange"><?=$ligne['titre']?></a><br><?=$ligne['sousTitre']?> <?=$ligne['tome']?></div></td>
                <td align="center" valign="middle" class="fietbas">
<?
if ($ligne['couverture']!="")
	{
	?>
	<a href="/data/<?=$ligne['couverture']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$ligne['couverture'],100,50)?>"></a>
    <?
	}  
?>
<input type="hidden" id="LGNOM1<?=$cpt?>" value="<?=$ligne['titre']?>">
<input type="hidden" id="LGNOM2<?=$cpt?>" value="matable_<?=$ligne['id']?>">
				</td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$aut['nom']?> <?=$aut['prenom']?></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$edi['nom']?></div></td>
                <td  align="center" valign="middle" class="fietbas">&nbsp;
<?
if (strlen($ligne['lien_fnac'])>7)
	{
	?>
    <img src="/images/FNAC.jpg" height="30">
    <?
	}
?>
                </td>
                <td  align="center" valign="middle" class="fietbas"><div align="center">
<?
$n=0;
$req="select count(*) as n from livres_reponses where idLivre=".$ligne['id'];
$mysql_result22 = mysql_query($req,$connexion) ;
if ($ligne22 = mysql_fetch_array($mysql_result22)) 
	$n=$ligne22['n'];
?>                
                <a href="livres_notes.php?id=<?=$ligne['id']?>" class="Style1">N (<?=$n?>)</a></div></td>
                <td align="center" valign="middle" class="fietbas">
<?
if ($ligne['publi']==0)
	{
	?>
    <a href="livres.php?publi=1&id=<?=$ligne['id']?>"><img src="images/rouge.gif" border="0" title="Non publié. Cliquez pour la mettre en ligne."></a>
    <?
	}
else
	{
	?>
    <a href="livres.php?publi=0&id=<?=$ligne['id']?>"><img src="images/vert.gif" border="0" title="En ligne. Cliquez pour ne plus la publier."></a>
    <?
	}
?>                
                </td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="livres_mod.php?id=<?=$ligne['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_livre('<?=str_replace("'","\'", htmlspecialchars($ligne['titre']))?>','<?=$ligne['id']?>');"><img src="images/bout_delete.gif" title="SUPPRIMER" width="18" height="18" border="0"></a></div></td>

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
                <td align="left" valign="middle" class="fietbas"><div align="left"class="ssttorange"><a href="livres_mod.php?id=0">Nouveau livre</a></div></td>
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
