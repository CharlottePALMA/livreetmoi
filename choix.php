<?php
require 'inc/intro.php';


$req="select * from livres where id=".secure($_GET['id']);
$mysql_result2 = mysql_query($req,$connexion) ;
$livre = mysql_fetch_array($mysql_result2);


?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Livre et moi</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
   		<link rel="stylesheet" href="assets/css/styles.css" />
   		<link rel="stylesheet" href="assets/css/yves.css" />
        <link rel="stylesheet" href="assets/css/dark.css" />
        <link rel="stylesheet" href="assets/css/historique.css" />
        <link rel="stylesheet" href="assets/css/policier.css" />
        <link rel="stylesheet" href="assets/css/aventure.css" />
        <link rel="stylesheet" href="assets/css/classique.css" />
        <link rel="stylesheet" href="assets/css/realiste.css" />
        <link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Just+Another+Hand' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Black+Ops+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Fontdiner+Swanky' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
        <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<script src="assets/js/jquery.min.js"></script>

		<script>
		function changeEtat(n)
		{
		$.ajax({
		  type: "POST",
		  url: "ajax.php",
		  data: { action:'changeEtat', n:n , id:<?=$livre['id']?>}
		}).done(function( msg ) {
				self.parent.location.href="/index.php?a=<?=rand(1,999999)?>#biblio";
				});

		}
		</script>

        </head>
	<body>
		<div style="padding:10px; color:#FFF">
			<h1 class="titre" style="color:#FFF"><?=$livre['titre']?> <br> <?=$livre['sousTitre']?></h1>

            <?
			if ($livre['couverture']!="")
				{
				?>
				<img src="<?=vignette2("/data/".$livre['couverture'],300,400)?>" align="left" class="ombre2" style="margin-right:20px;">
				<?
				}
				
				
			$req="select * from bibliotheque where idUtilisateur=".secure($_SESSION['user'])." and idLivre=".secure($livre['id']);
			$res=mysql_query($req,$connexion);
			$bib = mysql_fetch_array($res);
			
			$ch1=""; $ch2=""; $ch3="";
			if ($bib['etat']==1) $ch1=" checked ";
			if ($bib['etat']==2) $ch2=" checked ";
			if ($bib['etat']==3) $ch3=" checked ";
			?>
            
            <a href="index.php?livre=<?=$livre['id']?>#recherche" target="_top"> Voir la fiche détaillée </a>
         	<br>
            <br>
            <input type="radio" value="1" onClick="javascript:changeEtat(1);" name="choix" <?=$ch1?>> J'ai lu ce livre 
            <br>
            <input type="radio" value="2" onClick="javascript:changeEtat(2);" name="choix" <?=$ch2?>> Je suis entrain de lire ce livre 
            <br>
            <input type="radio" value="3" onClick="javascript:changeEtat(3);" name="choix" <?=$ch3?>> Je souhaite le lire 
			<?
			// Si l'url FNAC est renseignée, on fait un lien vers la FNAC
			if (strlen($livre['lien_fnac'])>7)
				{
				$url0="http://clic.reussissonsensemble.fr/click.asp?ref=755667&site=14485&type=text&tnb=3&diurl=http%3A%2F%2Feultech.fnac.com%2Fdynclick%2Ffnac%2F%3Feseg-name%3DaffilieID%26eseg-item%3D%24ref%24%26eaf-publisher%3DAFFILINET%26eaf-name%3Dg%3Fn%3Frique%26eaf-creative%3D%24affmt%24%26eaf-creativetype%3D%24affmn%24%26eurl%3D";
				$url2="%253FOrigin%253Daffilinet%2524ref%2524";
				$url1=trim($livre['lien_fnac']);
				$url1=urlencode($url1);
				$url1=urlencode($url1);
				?>
                <br><br>
                <a href="<?=$url0.$url1.$url2?>" target="_blank"><img src="/images/FNAC.jpg" height="30" class="ombre"> Acheter <?=$livre['titre']?> <?=$livre['sousTitre']?> à la FNAC</a>
                <?
				}
			?>
            <br>
        </div>
	</body>
</html>
