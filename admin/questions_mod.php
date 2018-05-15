<?
require '../inc/intro.php';
require '../inc/accesG.php';




$cpt=0;
$req="select * from questions where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;
if ($ligne = mysql_fetch_array($mysql_result))
	{
	}
else
	{
	if (isset($_GET['q']))
		$ligne['quest_parente']=$_GET['q'];
	if (isset($_GET['r']))
		$ligne['rep_parente']=$_GET['r'];
	}


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
              <td align="right" valign="middle"><div align="right" class="ttvert">Questions</div></td>
            </tr>
          </table>

            <form method="post" action="questions.php" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?=$_GET['id']?>">
              <input type="hidden" name="quoi" value="modif">
              <table width="<?=$w?>" border="0" cellspacing="0" cellpadding="3" id="O1">
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Question</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="question" type="text" class="txtfieldxlarge" value="<?=$ligne['question']?>">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Question parente</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="quest_parente">
					    <option value="0" >Aucune</option>
<?
$req="select * from questions order by quest_parente,ordre ";
$mysql_result2 = mysql_query($req,$connexion) ;
while ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	$sel=""; if ($ligne['quest_parente']==$ligne2['id']) $sel=" selected ";
	?>
    <option value="<?=$ligne2['id']?>" <?=$sel?>><?=$ligne2['question']?></option>
    <?
	}
?>
                      </select>
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Réponse parente</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <select name="rep_parente">
					    <option value="0" >Aucune</option>
<?
$req="select * from questions where id=".$ligne['quest_parente'];
$mysql_result2 = mysql_query($req,$connexion);
if ($ligne2 = mysql_fetch_array($mysql_result2)) 
	{
	for ($i=1;$i<=15;$i++)
	if (trim($ligne2['rep'.$i])!="")
		{
		$sel=""; 
		if ($ligne['quest_parente']==$ligne2['id']) 
		if ($ligne['rep_parente']==$i) 
			$sel=" selected ";
	?>
    <option value="<?=$i?>" <?=$sel?>><?=$ligne2['rep'.$i]?></option>
    <?
		}
	}
?>
                      </select>
                </div></td>
              </tr>

<?
for ($i=1;$i<=15;$i++)
	{
	?>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Réponse <?=$i?></b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="rep<?=$i?>" type="text" class="txtfieldxlarge" value="<?=$ligne['rep'.$i]?>">
                </div></td>
              </tr>
	<?
	}
?>
              
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
        <p align="center"><br></p>        
        </td>
    </tr>
  </table>
<? require 'inc_bottom.php'; ?>
</div>
</body>
</html>
