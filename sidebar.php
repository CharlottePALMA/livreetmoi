<?
if (!isset($_SESSION['user']))
	{
	// pas connecté
	?>
    <section id="sidebar">
   		<div id="cadreLogo"> 
        	<img src="images/LOGO.png" id="logo">
        </div>    
        <div class="inner">
            <nav>
                <ul>
                    <li><a href="#intro">Accueil</a></li>
                    <li><a href="#recherche">Trouver un livre</a></li>
                    <li><a href="#one">Se connecter</a></li>
                    <li><a href="#two">A propos</a></li>
                    <li><a href="#three">Contactez-nous !</a></li>
                </ul>
            </nav>
        </div>
    </section>
    <?
	}
else
	{
	?>
    <section id="sidebar">
    	<div id="cadreLogo"> 
        	<img src="images/LOGO.png" id="logo">
        </div> 
        <div class="inner">
            <nav>
                <ul>
                    <li><a href="#intro">Acceuil</a></li>
                    <li><a href="#recherche">Trouver un livre</a></li>
                    <li><a href="#biblio">Ma bibliothèque</a></li>
                    <li><a href="#compte">Mon compte</a></li>
                    <li><a href="#two">A propos</a></li>
                    <li><a href="#three">Contactez-nous !</a></li>
                    <li><a href="#logout" onClick="javascript:go('/logout.php');">Se déconnecter</a></li>
                </ul>
            </nav>
        </div>
    </section>
	<?
	}
?>