<?php
require 'inc/intro.php';


$req="select * from auteurs where id=".secure($_GET['id']);
$mysql_result2 = mysql_query($req,$connexion) ;
$auteur = mysql_fetch_array($mysql_result2);


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
        </head>
	<body>
		<div style="padding:10px; color:#FFF">
			<h1 class="titre" style="color:#FFF"><?=$auteur['prenom']?> <?=$auteur['nom']?></h1>

            <?
			if ($auteur['photo']!="")
				{
				?>
				<a href="/data/<?=$auteur['photo']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$auteur['photo'],300,400)?>" align="left" class="ombre2" style="margin-right:20px;"></a>
				<?
				}
			?>
            
            <?=$auteur['bio']?>
            
            <h2 style="color:#FFF">Ses livres :</h2>
			<?
			$req="select * from livres where idAuteur=".$auteur['id']." order by titre,tome,sousTitre";
			$mysql_result = mysql_query($req,$connexion) ;
			while ($livre = mysql_fetch_array($mysql_result))
			if ($livre['couverture']!="")
				{
				?>
				<a href="/index.php?livre=<?=$livre['id']?>#recherche" target="_top"><img src="<?=vignette2("/data/".$livre['couverture'],100,100)?>" title="<?=$livre['titre']?> <?=$livre['sousTitre']?>"></a>
				<?
				}
			
			?>
            <br>
        </div>
	</body>
</html>
