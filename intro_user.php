<?
$temps=0;
$prix=0;
$pages=0;
$nbe=0;
$req="select * from bibliotheque where idUtilisateur=".secure($_SESSION['user'])." and etat=1 order by id ";
$res=mysql_query($req,$connexion);
while ($rep=mysql_fetch_array($res))
	{
	$req="select * from livres where id=".secure($rep['idLivre']);
	$mysql_result = mysql_query($req,$connexion) ;
	$livre = mysql_fetch_array($mysql_result);
	
	$temps+=$livre['tpsLecture'];
	$prix+=$livre['prix'];
	$pages+=$livre['nbPage'];
	
	if ($edi[$livre['idEditeur']]!=1)
		{
		$nbe++;
		$edi[$livre['idEditeur']]=1;
		}
	}

$jours=floor($temps/24);	
$heures=round($temps - $jours*24);

$js="s"; if ($jours<2) $js="";
$hs="s"; if ($heures<2) $hs="";
$es="s"; if ($nbe<2) $es="";

?>
<section id="intro" class="wrapper style1 fullscreen fade-up">

	<div id="titreUser" style="display:inline-block;">
		<span class="part" id='nb1'> Vous avez passé <?=$jours?> jour<?=$js?> et <?=$heures?> heure<?=$hs?> à lire </span>
        <br>
		<div class='part' id='nb2'>Si vous avez acheté ces livres, <br> vous avez dépensé <?=$prix?> &euro;  </div>
        <div class='part' id='nb3'>Si vous empruntez, <br> vous économisez <?=$prix?> &euro; </div>
        <br>
        <span class="part" id='nb4'> Vous avez tourné <?=$pages?> pages </span>
        <br>
        <span class="part" id='nb5'> Vous avez lu des livres de <?=$nbe?> éditeur<?=$es?> différent<?=$es?> </span>
        <br>
        <br>
	</div>
    
</section>