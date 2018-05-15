<?php
require 'inc/intro.php';


if ($_POST['quoi']=="ajout_biblio")
	{
	$req="insert into bibliotheque (`idUtilisateur`, `idLivre`, `etat`, `note`, `commentaire`, `favoris`) VALUES (";
	$req.="'".secure($_SESSION['user'])."', ";
	$req.="'".secure($_POST['idLivre'])."', ";
	$req.="'".secure($_POST['type'])."', ";
	$req.="'".secure($_POST['etoile'])."', ";
	$req.="'".secure($_POST['texte'])."', 0)";
	$res=mysql_query($req,$connexion);
	}


if (!isset($_GET['livre'])) unset($_SESSION['note']);
$question=1;	





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
        <link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
        <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />


        <script>
		
		function ma_reponse(q,r)
		{
		$.ajax({
		  type: "POST",
		  url: "ajax.php",
		  data: { action:'reponse', q:q,r:r }
		}).done(function( msg ) {
				$( "#divQuestion" ).html(msg);
				$(".fancy").fancybox({
								maxWidth	: 800,
								maxHeight	: 600,
								fitToView	: false,
								width		: '70%',
								height		: '70%',
								autoSize	: false,
								closeClick	: false,
								openEffect	: 'none',
								closeEffect	: 'none'
							});				
				});
			
		}
		
		function valide_form(id)
		{
		$("#"+id).submit();
		}
		
		function go(url)
		{
		document.location=url;
		}
		
		</script>	
        </head>
	<body>
    
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-1290632-44', 'auto');
  ga('send', 'pageview');
 
</script>

		<!-- Sidebar -->
			<? require 'sidebar.php'; ?>

		<!-- Wrapper -->
			<div id="wrapper">

					<? 
					if (!isset($_SESSION['user']))
						{
					 	require 'intro.php'; 
						}
					else
						{
					 	require 'intro_user.php'; 
						}

					require 'recherche.php'; 
					
					if (!isset($_SESSION['user']))
						{
					 	require 'connexion.php'; 
						}
					else
						{
					 	require 'biblio.php'; 
					 	require 'compte.php'; 
						}
					require 'apropos.php'; 
					require 'contact.php'; 
					?>

			</div>

		<!-- Footer -->
			<footer id="footer" class="wrapper style1-alt">
				<div class="inner">
					<ul class="menu">
						<li>&copy; 2016 - Charlotte Palma</li>
					</ul>
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
			<script>
                    $(document).ready(function() {
                        $(".fancy").fancybox({
                            maxWidth	: 800,
                            maxHeight	: 600,
                            fitToView	: false,
                            width		: '70%',
                            height		: '70%',
                            autoSize	: false,
                            closeClick	: false,
                            openEffect	: 'none',
                            closeEffect	: 'none'
                        });
                    });
			</script>
	</body>
</html>