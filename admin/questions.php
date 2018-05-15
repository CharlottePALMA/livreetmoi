<?
require '../inc/intro.php';
require '../inc/accesG.php';



if ($_GET['del']>0)
	{
	// suppression d'un compte
	$req="delete from questions where id=".secure($_GET['del']);
	$mysql_result = mysql_query($req,$connexion) ;
	}
	
if (isset($_GET['publi']))
	{
	$req="update questions set ";
	$req.="publi=".mysql_real_escape_string(stripslashes($_GET['publi']));
	$req.=" where id=".mysql_real_escape_string(stripslashes($_GET['id']));
	$mysql_result = mysql_query($req,$connexion) ;
	}


if ($_POST['quoi']=="modif")
	{
	// on vérifie la bonne saisie des champs obligatoires
	if (strlen(trim($_POST['question']))<1) 	message_erreur('Veuillez remplir le champ "Question"');
	
	if ($_POST['id']==0)
		{
		$req="insert into questions ( `question`) values (";
		$req.="'".secure(trim($_POST['question']))."')";
		$mysql_result = mysql_query($req,$connexion) ;
		$id=mysql_insert_id();
		$_POST['id']=$id;
		}
	
	$req="update questions set ";
	$req.="question='".secure(trim($_POST['question']))."', ";
	for ($i=1;$i<=15;$i++)
		$req.="rep".$i."='".secure(trim($_POST['rep'.$i]))."', ";
	$req.="quest_parente='".secure(trim($_POST['quest_parente']))."', ";
	$req.="rep_parente='".secure(trim($_POST['rep_parente']))."' ";
	$req.="where id=".secure($_POST['id']);
	$mysql_result = mysql_query($req,$connexion) ;
	
	}


if (isset($_POST['matable']))
	{
	foreach( $_POST['matable'] as $order => $id )
		{
			$req='UPDATE questions SET ordre = \'' . secure( $order ) . '\' WHERE id = \'' . secure( $id ) . '\'';
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
		$.post('questions.php',order); // appel ajax au fichier ajax.php avec l'ordre des photos
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
              <td align="right" valign="middle"><div align="right" class="ttvert">Questions</div></td>
            </tr>
          </table>
          <br>
          <?
$tid="matable";

?>
          <br>
            <table width="690" border="0" cellspacing="0" cellpadding="5" id="<?=$tid?>">
              <tr class="pas_moi">
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Question</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Réponses</b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
                <td width="20" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier"><b></b></div></td>
              </tr>
<?
$cpt=0;
$req="select * from questions where quest_parente=0 order by ordre";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$cpt++;
		
?>
              <tr id="matable_<?=$ligne['id']?>">
                <td align="left" valign="middle" class="fietbas"><div align="left"><a href="questions_mod.php?id=<?=$ligne['id']?>&v=1" class="lienorange"><?=$ligne['question']?></a></div></td>
                <td align="left" valign="middle" class="fietbas">
<?
for ($i=1;$i<=15;$i++)
if (trim($ligne['rep'.$i])!="")
	{
	?>
	<?=$ligne['id']."_".$i?> <?=$ligne['rep'.$i]?> [<a href="questions_mod.php?q=<?=$ligne['id']?>&r=<?=$i?>">+</a>]<br>
    <?
	}  
?>
				</td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="questions_mod.php?id=<?=$ligne['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
                <td  align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_question('<?=str_replace("'","\'", htmlspecialchars($ligne['question']))?>','<?=$ligne['id']?>');"><img src="images/bout_delete.gif" title="SUPPRIMER" width="18" height="18" border="0"></a></div></td>

              </tr>
<?



	$req="select * from questions where quest_parente=".$ligne['id']." order by rep_parente, ordre";
	$mysql_result2 = mysql_query($req,$connexion) ;
	while ($ligne2 = mysql_fetch_array($mysql_result2)) 
		{
		$cpt++;
			
	?>
			  <tr id="matable_<?=$ligne2['id']?>">
					<td align="left" valign="middle" class="fietbas"><div align="left" style="margin-left:20px;">
                    <b><?=$ligne['rep'.$ligne2['rep_parente']]?></b><br>
                    <a href="questions_mod.php?id=<?=$ligne2['id']?>&v=1" class="lienorange"><?=$ligne2['question']?></a></div></td>
				<td align="left" valign="middle" class="fietbas">
	<?
	for ($i=1;$i<=15;$i++)
	if (trim($ligne2['rep'.$i])!="")
		{
		?>
		<?=$ligne2['id']."_".$i?> <?=$ligne2['rep'.$i]?> [<a href="questions_mod.php?q=<?=$ligne2['id']?>&r=<?=$i?>">+</a>]<br>
		<?
		}  
	?>
			    </td>
				<td  align="center" valign="middle" class="fietbas"><div align="center"><a href="questions_mod.php?id=<?=$ligne2['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
					<td  align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_question('<?=str_replace("'","\'", htmlspecialchars($ligne2['question']))?>','<?=$ligne2['id']?>');"><img src="images/bout_delete.gif" title="SUPPRIMER" width="18" height="18" border="0"></a></div></td>
	
				  </tr>
	<?


	$req="select * from questions where quest_parente=".$ligne2['id']." order by rep_parente, ordre";
	$mysql_result3 = mysql_query($req,$connexion) ;
	while ($ligne3 = mysql_fetch_array($mysql_result3)) 
		{
		$cpt++;
			
	?>
				  <tr id="matable_<?=$ligne3['id']?>">
					<td align="left" valign="middle" class="fietbas"><div align="left" style="margin-left:40px;">
                    <b><?=$ligne2['rep'.$ligne3['rep_parente']]?></b><br>
                    <a href="questions_mod.php?id=<?=$ligne3['id']?>&v=1" class="lienorange"><?=$ligne3['question']?></a></div></td>
					<td align="left" valign="middle" class="fietbas">
	<?
	for ($i=1;$i<=15;$i++)
	if (trim($ligne3['rep'.$i])!="")
		{
		?>
		<?=$ligne3['id']."_".$i?> <?=$ligne3['rep'.$i]?> [<a href="questions_mod.php?q=<?=$ligne3['id']?>&r=<?=$i?>">+</a>]<br>
		<?
		}  
	?>
					</td>
					<td  align="center" valign="middle" class="fietbas"><div align="center"><a href="questions_mod.php?id=<?=$ligne3['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
					<td  align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_question('<?=str_replace("'","\'", htmlspecialchars($ligne3['question']))?>','<?=$ligne3['id']?>');"><img src="images/bout_delete.gif" title="SUPPRIMER" width="18" height="18" border="0"></a></div></td>
	
				  </tr>
	<?
		}



		}





	}
?>              
          </table>
            <br>
        </div>        
        <div align="center"><br>
            <br>
            <table width="690" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="fietbas"><div align="left"class="ssttorange"><a href="questions_mod.php?id=0">Nouvelle question</a></div></td>
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
