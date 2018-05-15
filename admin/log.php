<?
require '../inc/intro.php';
unset($_SESSION['admin']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$titre_principal?> - Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="stylesadmin.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center"><br>
  <br>
  <br>
  <img src="images/toplogin.jpg" width="963" height="91"><br>
  <br>
  <br>
  <br>
  <br>
<br>
  <br>
<?
if (isset($_GET['ko']))
	{
	// on revient sur cette page avec un message d'erreur à afficher
	?>
  <table width="400" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" valign="middle"><div align="left"class="ttorange">Erreur d'identification</div></td>
    </tr>
  </table>
<br>
<br>
    <?
	}
?>  
  <form method="post" action="log2.php"> 
  <br>
  <br>
  <table width="400" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td align="left" valign="middle"><div align="left">Utilisateur</div></td>
      <td align="left" valign="middle">
        <div align="left">
          <input name="login" type="text" class="txtfieldcoordonnees" style="width:200px;">
      </div></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><div align="left">Mot de passe </div></td>
      <td align="left" valign="middle">
        <div align="left">
          <input name="pass" type="password" class="txtfieldcoordonnees" style="width:200px;">
      </div></td>
    </tr>
    <tr>
      <td align="left" valign="middle" class="filetbottom"><div align="left"></div></td>
      <td align="left" valign="middle" class="filetbottom"><div align="left"><input type="image" src="images/bout_valider.gif" alt="OK" vspace="5" border="0"><br>
        <br>
      </div></td>
    </tr>
  </table></form>
  <br>
  <p align="center">&nbsp;</p>
</div>
</body>
</html>
