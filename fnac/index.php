<?php 
?>
<html>
<title>Acheter à la FNAC</title>
<body>
<center>
<font face="verdana" size="2">
<br><br><br>
<form method="GET" action="index.php">
  <p>&nbsp;  </p>
  <p>
  	Copiez/collez l'URL du livre sur le site de la FNAC (de type http://livre.fnac.com/a113201/Rene-Barjavel-L-enchanteur ) dans la zone ci-dessous<br><br>
    <input type="text" placeholder="URL du livre sur le site de la FNAC" name="titre" style="width:95%; text-align:center">
    <br><br>
    <input type="submit" value="GENERER LE LIEN">
  </p>
</form>
<br>
<br>
<br>
<br>
<?

if (isset($_GET['titre']))
	{
		

				$url0="http://clic.reussissonsensemble.fr/click.asp?ref=755667&site=14485&type=text&tnb=3&diurl=http%3A%2F%2Feultech.fnac.com%2Fdynclick%2Ffnac%2F%3Feseg-name%3DaffilieID%26eseg-item%3D%24ref%24%26eaf-publisher%3DAFFILINET%26eaf-name%3Dg%3Fn%3Frique%26eaf-creative%3D%24affmt%24%26eaf-creativetype%3D%24affmn%24%26eurl%3D";
				$url2="%253FOrigin%253Daffilinet%2524ref%2524";
				$url1=trim($_GET['titre']);
				$url1=urlencode($url1);
				$url1=urlencode($url1);
				?>
                <br><br>
                <a href="<?=$url0.$url1.$url2?>" target="_blank"><img src="/images/FNAC.jpg" height="30" class="ombre"> Acheter à la FNAC</a>
                <?
	}

?>
