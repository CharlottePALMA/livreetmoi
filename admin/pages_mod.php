<?
require '../inc/intro.php';
require '../inc/accesG.php';


if (isset($_POST['matable']))
	{
	foreach( $_POST['matable'] as $order => $id )
		{
			$req='UPDATE cata_fichiers SET ordre = \'' . secure( $order ) . '\' WHERE id = \'' . secure( $id ) . '\'';
			$mysql_result = mysql_query($req,$connexion) ;
			echo $req."\n";
		}
	die();
	}


$cpt=0;
$req="select * from pages where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;
if (!$ligne = mysql_fetch_array($mysql_result)) message_erreur("Page inexistante");


	$is_img="display:none;";
	$is_url="display:none;";

$w="690";
$hi="";
if ($_GET['v']!=1)
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
	height : '900px',
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
              <td align="right" valign="middle"><div align="right" class="ttvert">Pages</div></td>
            </tr>
          </table>
<?
if ($_GET['v']==1)
	{
	?>
    
              <table width="<?=$w?>" border="0" cellspacing="0" cellpadding="3" id="O1">
              <tr>
                <td align="left" valign="middle" width="150"><div align="left"><b>Pour modifier, cliquez sur : </b></div></td>
                <td align="left" valign="middle"><div align="left"><a href="pages_mod.php?id=<?=$ligne['id']?>" class="Style1"><img src="images/edit.gif" title="MODIFIER"  border="0"></a></div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Catégorie</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="categ">
<?
$req="select * from pages_categories where etat<9 order by ordre";
$mysql_result2 = mysql_query($req,$connexion) ;
while ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	$sel=""; if ($ligne['categorie']==$ligne2['id']) $sel=" selected ";
	if ($sel!="")
		{
	?>
    <option value="<?=$ligne2['id']?>" <?=$sel?>><?=$ligne2['categorie']?></option>
    <?
		}
	}
?>
                      </select>
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Titre</b></div></td>
                <td align="left" valign="middle"><div align="left"><?=$ligne['titre']?></div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Date</b></div></td>
                <td align="left" valign="middle"><div align="left"><?=dateen2fr($ligne['date'])?></div></td>
              </tr>

              <tr>
                <td align="left" valign="middle" colspan="2" style="background-color:#DDDDDD">
                  <?=$ligne['texte']?>
                </td>
              </tr>
          </table>
    <?
	}
else
	{
	?>
            <form method="post" action="pages.php" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?=$ligne['id']?>">
              <input type="hidden" name="quoi" value="modif">
              <table width="<?=$w?>" border="0" cellspacing="0" cellpadding="3" id="O1">
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Catégorie</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="categ">
<?
$req="select * from pages_categories where etat<9 order by ordre";
$mysql_result2 = mysql_query($req,$connexion) ;
while ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	$sel=""; if ($ligne['categorie']==$ligne2['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne2['id']?>" <?=$sel?>><?=$ligne2['categorie']?></option>
    <?
	}
?>
                      </select>
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Titre</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="titre" type="text" class="txtfieldxlarge" value="<?=$ligne['titre']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Date</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="date" type="text" class="txtfield" value="<?=dateen2fr($ligne['date'])?>">
                </div></td>
              </tr>


              <tr style="<?=$is_url?>">
                <td align="left" valign="middle"><div align="left"><b>Adresse web (url) - Doit commencer par http://</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="url" type="text" class="txtfieldxlarge" value="<?=$ligne['url']?>">
                </div></td>
              </tr>


              <tr style="<?=$is_img?>">
                <td align="left" valign="middle"><div align="left"><b>Image <?=$taille_image?></b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <?
if ($ligne['image']!="")
	{
	?>
	<a href="/data/<?=$ligne['image']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$ligne['image'],200,200)?>"></a><br>
    <input type="checkbox" name="delimage" value="1"> Effacer cette image<br><br>
    <?
	}
?>
                  <input name="image" type="file">
                </div></td>
              </tr>

              <tr>
                <td align="left" valign="middle" colspan="2">
                  <textarea name="texte" class="editor" style="width:<?=($w-10)?>px;height:1900px;" id="editor1"><?=$ligne['texte']?></textarea>
                </td>
              </tr>
              
              <tr>
                <td align="left" valign="middle"><div align="left"><br><br>
                <input type="image" src="images/bout_valider.gif" alt="OK"  vspace="5" border="0">
                
                <img src="images/bout_annuler.gif" alt="ANNULER"  vspace="5" border="0" onClick="javascript:history.back();" style="cursor:pointer">
                </div></td>
              </tr>
          </table>
            </form>
	<?
	}
?>
            <br>
        </div>
        <p align="center"><br></p>        
        </td>
    </tr>
  </table>
<? require 'inc_bottom.php'; ?>
</div>
</body>
</html>
