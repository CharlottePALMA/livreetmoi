<?
require '../inc/intro.php';
require '../inc/accesG.php';



$cpt=0;
$req="select * from livres where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;
$ligne0 = mysql_fetch_array($mysql_result);



$w="690";
$hi="";
if (1>3)
	{
	$hi="display:none;";
	$w="960";
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$titre_principal?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<? require 'inc_meta.php'; ?>
<script src="/ckeditor/ckeditor.js"></script>
<script src="/ckeditor/adapters/jquery.js"></script>

<script>
$(document).ready( function(){ // quand la page a fini de se charger

  	CKEDITOR.replace( 'editor1', {
//	filebrowserBrowseUrl : '/pdw_file_browser/index.php?editor=ckeditor',
//	filebrowserImageBrowseUrl : '/pdw_file_browser/index.php?editor=ckeditor&filter=image',
//	filebrowserFlashBrowseUrl : '/pdw_file_browser/index.php?editor=ckeditor&filter=flash',
	height : '500px',
	width : '<?=($w-10)?>px',
	});

});

</script>
<style>
ul#matable{
  list-style:none;
  /* height:140px; */
}
/* style des éléments de la liste */
ul#matable li{
  border:1px solid #ddd;
  padding:5px;
  cursor:move;
  height:50px;
  width:400px;
  float:left;
  margin-left:-40px;
  margin-right:8px;
  margin-bottom:5px;
  background:#fff;
  color:#212326;
  font-size:11px;
  -moz-box-shadow:2px 2px 5px #ccc;
}
/* style de l'élément fantome, qui apparait losque que l'on bouge un élément */
ul#matable li.highlight{
  background:#f2f2f2;
  background-color:#FF0;
  border:1px dashed #212326;
}

ul.simple{
width: 100% ;
}
ul.simple li {
display:block;
width : 33%;
height : 34px;
float:left;
}
ul.simple li[float="left"] + li {
float:none;
}

</style>

</head>



<body>
<div align="center"><? require 'inc_top.php'; ?>
<table width="963" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="200" align="left" valign="top" class="fietD" style="<?=$hi?>"><div align="left">
		<br>
		<? require 'inc_menu.php'; ?>
		<br>
      </div>
      </td>
      <td align="center" valign="top" class="filetleftrightbottom">        
        <div align="center"><br>
          <br>
          <table width="<?=$w?>" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right" valign="middle"><div align="right" class="ttvert">Livres</div></td>
            </tr>
          </table>

            <form method="post" action="livres.php" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?=$ligne0['id']?>">
              <input type="hidden" name="quoi" value="notes">
              <table width="<?=$w?>" border="0" cellspacing="0" cellpadding="3" id="O1">
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Auteur</b></div></td>
                <td align="left" valign="middle"><div align="left">
<?
$req="select * from auteurs where id=".$ligne0['idAuteur'];
$mysql_result2 = mysql_query($req,$connexion) ;
if ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	?>
    <?=$ligne2['nom']?> <?=$ligne2['prenom']?>
    <?
	}
?>
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Titre</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <?=$ligne0['titre']?>
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Soustitre</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <?=$ligne0['sousTitre']?>
                </div></td>
              </tr>


<tr><td colspan="2">
<br><br>

<table width="690" border="0" cellspacing="0" cellpadding="5" id="ZZZ">
              <tr class="pas_moi">
                <td width="200" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Question</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Réponses</b></div></td>
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
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$ligne['question']?></div></td>
                <td align="left" valign="middle" class="fietbas">
<?
for ($i=1;$i<=15;$i++)
if (trim($ligne['rep'.$i])!="")
	{
	$ch="";
	$req="select * from livres_reponses where idLivre=".$ligne0['id']." and idQuestion=".$ligne['id']." and idReponse=".$i;
	$mysql_result22 = mysql_query($req,$connexion) ;
	if ($ligne22 = mysql_fetch_array($mysql_result22)) 
		$ch=" checked ";
	?>
	<input type="checkbox" name="CK<?=$ligne['id']?>_<?=$i?>" value="1" <?=$ch?>> <?=$ligne['rep'.$i]?><br>
    <?
	}  
?>
				</td>
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
                    <?=$ligne2['question']?></div></td>
				<td align="left" valign="middle" class="fietbas">
	<?
	for ($i=1;$i<=15;$i++)
	if (trim($ligne2['rep'.$i])!="")
		{
		$ch="";
		$req="select * from livres_reponses where idLivre=".$ligne0['id']." and idQuestion=".$ligne2['id']." and idReponse=".$i;
		$mysql_result22 = mysql_query($req,$connexion) ;
		if ($ligne22 = mysql_fetch_array($mysql_result22)) 
			$ch=" checked ";
		?>
		<input type="checkbox" name="CK<?=$ligne2['id']?>_<?=$i?>" value="1" <?=$ch?>> <?=$ligne2['rep'.$i]?><br>
		<?
		}  
	?>
			    </td>
	
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
                    <?=$ligne3['question']?></div></td>
					<td align="left" valign="middle" class="fietbas">
	<?
	for ($i=1;$i<=15;$i++)
	if (trim($ligne3['rep'.$i])!="")
		{
		$ch="";
		$req="select * from livres_reponses where idLivre=".$ligne0['id']." and idQuestion=".$ligne3['id']." and idReponse=".$i;
		$mysql_result22 = mysql_query($req,$connexion) ;
		if ($ligne22 = mysql_fetch_array($mysql_result22)) 
			$ch=" checked ";
		?>
		<input type="checkbox" name="CK<?=$ligne3['id']?>_<?=$i?>" value="1" <?=$ch?>> <?=$ligne3['rep'.$i]?><br>
		<?
		}  
	?>
					</td>
				  </tr>
	<?
		}



		}





	}
?>              
          </table>




</td></tr>

              
              <tr>
                <td align="left" valign="middle"><div align="left"><br><br>
                <input type="image" src="images/bout_valider.gif" alt="OK"  vspace="5" border="0">
                
                <img src="images/bout_annuler.gif" alt="ANNULER"  vspace="5" border="0" onClick="javascript:history.back();" style="cursor:pointer">
                </div></td>
              </tr>
          </table>
            </form>
            <br>
        </div>
        </td>
    </tr>
  </table>
<? require 'inc_bottom.php'; ?>
</div>
</body>
</html>
