<?php
/**************************************************************************************************

Le header de l'interface d'admin 
(positionné en haut de chaque page de l'admin)

La variable de session $_SESSION['phrase_admin'] est initialisée au moment du login avec le nom de la personne connectée et sa date de dernière connexion

**************************************************************************************************/
?>
<img src="images/topadmin.jpg" width="963" height="91" border="0" usemap="#Map">
  <map name="Map">
    <area shape="rect" coords="2,3,198,86" href="index.php" alt="ACCUEIL">
  </map>
  <table width="963" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="200" align="left" valign="middle" bgcolor="#4F4F4F"><div align="left"><img src="images/deconnexion.gif" width="11" height="10" hspace="5" align="absmiddle"><a href="logout.php" class="lienblanc">Déconnexion</a></div></td>
      <td align="right" valign="middle" bgcolor="#4F4F4F"><div align="right" class="txtblanc">
        <?=$_SESSION['phrase_admin']?>
      </div></td>
    </tr>
  </table>