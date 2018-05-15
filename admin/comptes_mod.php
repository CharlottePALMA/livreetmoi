<?
require '../inc/intro.php';
require '../inc/accesG.php';

$cpt=0;
$req="select * from comptes where id=".secure($_GET['id']);
$mysql_result = mysql_query($req,$connexion) ;
if (!$ligne = mysql_fetch_array($mysql_result)) message_erreur("Compte inexistant");
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
              <td align="right" valign="middle"><div align="right" class="ttvert">Utilisateurs</div></td>
            </tr>
          </table>
          <br>
          <br>
          <table width="690" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="middle" class="adfiletbottom"><div align="left"class="ssttorange">Modification d'un compte</div></td>
            </tr>
          </table>
          <br>
            <br>
            <form method="post" action="comptes_mod2.php">
              <input type="hidden" name="id" value="<?=$ligne['id']?>">
              <table width="400" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td align="left" valign="middle"><div align="left"><b>Nom</b></div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="nom" type="text" class="txtfieldcoordonnees" value="<?=$ligne['nom']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left"><b>Pr&eacute;nom</b></div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="prenom" type="text" class="txtfieldcoordonnees" value="<?=$ligne['prenom']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left">Identifiant</div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="login" type="text" class="txtfieldcoordonnees" value="<?=$ligne['login']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left">Mot de passe </div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="pass" type="text" class="txtfieldcoordonnees" value="<?=$ligne['password']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left">Email </div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="email" type="text" class="txtfieldcoordonnees" value="<?=$ligne['email']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left">Tel </div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="tel" type="text" class="txtfieldcoordonnees" value="<?=$ligne['tel']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left">Fonction </div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input name="fonction" type="text" class="txtfieldcoordonnees" value="<?=$ligne['fonction']?>">
                  </div></td>
                </tr>
                <tr>
                  <td align="left" valign="middle"><div align="left"></div></td>
                  <td align="left" valign="middle"><div align="left">
                    <input type="image" src="images/bout_valider.gif" alt="VALIDER" width="90" height="24" vspace="5" border="0">
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
