<?
require '../inc/intro.php';
require '../inc/accesG.php';

//$yves=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$titre_principal?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<? require 'inc_meta.php'; ?>
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
              <td align="right" valign="middle"><div align="right" class="ttvert">Annuaire</div></td>
            </tr>
          </table>
          <br>
          <br>
            <table width="690" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="15" align="center" valign="middle" class="fietbas"><div align="center"></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Nom</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Email</b></div></td>
                <td width="120" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Tel</b></div></td>
                <td width="120" align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">-</b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><b class="tttabpanier">Dernière connection</b></div></td>
                <td width="90" align="center" valign="middle" class="fietbas"><div align="center" class="tttabpanier">
                  <div align="center"><b>Supprimer</b></div>
                </div></td>
              </tr>
<?
$cpt=0;
$req="select * from comptes order by nom,prenom";
$mysql_result = mysql_query($req,$connexion) ;
while ($ligne = mysql_fetch_array($mysql_result)) 
	{
	$der="-";
	$req="select * from logs where idlogin=".$ligne['id']." order by date desc";
	$mysql_result2 = mysql_query($req,$connexion) ;
	if ($ligne2 = mysql_fetch_array($mysql_result2)) 
		$der=dateen2fr($ligne2['date']);
	$cpt++;
?>
              <tr>
                <td align="center" valign="middle" class="fietbas"><div align="center"><b><?=$cpt?></b></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><a href="comptes_mod.php?id=<?=$ligne['id']?>" class="lienorange"><?=$ligne['nom']?> <?=$ligne['prenom']?></a></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><a href="mailto:<?=$ligne['email']?>" class="lienorange"><?=$ligne['email']?></a></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$ligne['tel']?></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$ligne['fonction']?></div></td>
                <td align="left" valign="middle" class="fietbas"><div align="left"><?=$der?></div></td>
                <td width="90" align="center" valign="middle" class="fietbas"><div align="center"><a href="javascript:confirme_suppression_compte('<?=str_replace("'","\'", htmlspecialchars($ligne['nom']))?>','<?=$ligne['id']?>');"><img src="images/bout_delete.gif" alt="DELETE" width="18" height="18" border="0"></a></div></td>
              </tr>
<?
	}
?>              
          </table>
            <br>
        </div>        
        <div align="center"><br><br>
            <br>
            <table width="690" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="fietbas"><div align="left"class="ssttorange"><a href='javascript:swap_id("nouveau","slow");'>Nouvel utilisateur</a></div></td>
              </tr>
          </table>
            <br>
            <br>
<form method="post" action="comptes_ajout.php" id="nouveau" style="display:none">
            <table width="400" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Nom</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="nom" type="text" class="txtfieldcoordonnees">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left"><b>Prénom</b></div></td>
                <td align="left" valign="middle"><div align="left">
                  <input name="prenom" type="text" class="txtfieldcoordonnees">
                </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left">Identifiant</div></td>
                <td align="left" valign="middle">
                  <div align="left">
                    <input name="login" type="text" class="txtfieldcoordonnees">
                  </div></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><div align="left">Mot de passe </div></td>
                <td align="left" valign="middle">
                  <div align="left">
                    <input name="pass" type="text" class="txtfieldcoordonnees">
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
