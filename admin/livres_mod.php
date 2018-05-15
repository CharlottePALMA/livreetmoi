<?
require '../inc/intro.php';
require '../inc/accesG.php';



$cpt=0;
$req="select * from livres where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;
$ligne = mysql_fetch_array($mysql_result);



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
              <input type="hidden" name="id" value="<?=$ligne['id']?>">
              <input type="hidden" name="quoi" value="modif">
              <table width="<?=$w?>" border="0" cellspacing="0" cellpadding="3" id="O1">
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Auteur</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="idAuteur">
<?
$req="select * from auteurs order by nom,prenom";
$mysql_result2 = mysql_query($req,$connexion) ;
while ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	$sel=""; if ($ligne['idAuteur']==$ligne2['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne2['id']?>" <?=$sel?>><?=$ligne2['nom']?> <?=$ligne2['prenom']?></option>
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
                <td align="left" valign="middle"><div align="left"><b>Soustitre</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="sousTitre" type="text" class="txtfieldxlarge" value="<?=$ligne['sousTitre']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Tome</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="tome" type="text" class="txtfieldxlarge" value="<?=$ligne['tome']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Editeur</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="idEditeur">
<?
$req="select * from editeurs order by nom";
$mysql_result2 = mysql_query($req,$connexion) ;
while ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	$sel=""; if ($ligne['idEditeur']==$ligne2['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne2['id']?>" <?=$sel?>><?=$ligne2['nom']?></option>
    <?
	}
?>
                      </select>
                </div></td>
              </tr>


              <tr>
                <td align="left" valign="middle"><div align="left"><b>Collection</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="collection" type="text" class="txtfieldxlarge" value="<?=$ligne['collection']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Nombre de pages</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="nbPage" type="text" class="txtfieldxlarge" value="<?=$ligne['nbPage']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Nombre de chapitres</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="nbChapitres" type="text" class="txtfieldxlarge" value="<?=$ligne['nbChapitres']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Prix</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="prix" type="text" class="txtfieldxlarge" value="<?=$ligne['prix']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Temps de lecture (en heures)</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="tpsLecture" type="text" class="txtfieldxlarge" value="<?=$ligne['tpsLecture']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>URL FNAC</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="lien_fnac" type="text" class="txtfieldxlarge" value="<?=$ligne['lien_fnac']?>">
                </div></td>
              </tr>


              <tr style="<?=$is_img?>">
                <td align="left" valign="middle"><div align="left"><b>Couverture <?=$taille_image?></b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <?
if ($ligne['couverture']!="")
	{
	?>
	<a href="/data/<?=$ligne['couverture']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$ligne['couverture'],200,200)?>"></a><br>
    <input type="checkbox" name="delimage" value="1"> Effacer cette image<br><br>
    <?
	}
?>
                  <input name="image" type="file">
                </div></td>
              </tr>

              <tr>
                <td align="left" valign="middle" colspan="2">
                <b>Résumé</b><br>
                  <textarea name="resume" class="editor" style="width:<?=($w-10)?>px;height:500px;" id="editor1"><?=$ligne['resume']?></textarea>
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
            <br>
        </div>
        </td>
    </tr>
  </table>
<? require 'inc_bottom.php'; ?>
</div>
</body>
</html>
