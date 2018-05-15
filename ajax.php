<?php
require 'inc/intro.php';



if ($_POST['action']=="changeEtat")
	{
	$req="update bibliotheque set etat=".secure($_POST['n'])." where idUtilisateur=".secure($_SESSION['user'])." and idLivre=".secure($_POST['id']);
	$res=mysql_query($req,$connexion);
	die();
	}

if ($_POST['action']=="cherche")
	{
	$req="select * FROM livres WHERE titre like '%".secure($_POST['r'])."%' and publi=1";		
	$res=mysql_query($req,$connexion);
	$i=0;
	while ($rep=mysql_fetch_array($res))
		{
		$i++;
		if ($i>15)
			{
			echo "...<br>";
			break;
			}
		else
			{
			?>
            <div class="plus2" id="ALI<?=$rep['id']?>">
                <a href="javascript:ajoute_biblio(<?=$rep['id']?>);" class="plus">
                <span class="fa fa-plus-circle" title="AJOUTER A MA BIBLIOTHEQUE"></span>
                </a>
                <a href="/index.php?livre=<?=$rep['id']?>#recherche"><?=$rep['titre']?></a> <?=$rep['sousTitre']?>
            </div>
			<?
            }
		}
	
	die();
	}

if ($_POST['action']=="reponse")
	{
	$question=secure($_POST['q']);
	$reponse=secure($_POST['r']);

	$req="select * FROM questions WHERE id=".$question;		
	$res=mysql_query($req,$connexion);
	$rep0=mysql_fetch_array($res);


	// stocker la réponse
	
	
	// stocker les notes
	$req="select * FROM livres_reponses WHERE idQuestion=".$question." and idReponse=".$reponse." ";		
	$res=mysql_query($req,$connexion);
	while ($rep=mysql_fetch_array($res))
		{
		if (!isset($_SESSION['note'][$rep['idLivre']]))
			$_SESSION['note'][$rep['idLivre']]=$rep['note'];
		else	
			$_SESSION['note'][$rep['idLivre']]+=$rep['note'];
		}
	
	
	// chercher la question suivante
	
	$req="select * FROM questions WHERE quest_parente=".$question." and rep_parente=".$reponse." order by ordre";		
	$res=mysql_query($req,$connexion);
	if ($rep=mysql_fetch_array($res))
		{
		$rep1=$rep;
		}
	else
		{
		$req="select * FROM questions WHERE quest_parente=".$rep0['quest_parente']." and rep_parente=".$rep0['rep_parente'];
		$req.=" and ordre>".$rep0['ordre']." order by ordre";		
		$res=mysql_query($req,$connexion);
		if ($rep=mysql_fetch_array($res))
			{
			$rep1=$rep;	
			}
		else
			{
			$rep1=NULL;
			}
		}
	
	if ($rep1!=NULL)
		{
		?>
<h1><?=$rep1['question']?></h1>
<p><? 
for ($i=1;$i<=15;$i++)
	{
	if ($rep1['rep'.$i]!="")
		{
		?> 
        <a class="st<?=$rep1['id']?>_<?=$i?> lien" href="javascript:ma_reponse(<?=$rep1['id']?>,<?=$i?>);"><?=str_replace(" ","&nbsp;",$rep1['rep'.$i])?></a>
        <?	
		}
	}
?></p>
        <?
		}
	else
		{
		$i=0;
		arsort($_SESSION['note']);
		foreach ($_SESSION['note'] as $k => $v)
			{
			$i++;
			if ($i==1)
				{
				$req="select * from livres where id=".secure($k);
				$mysql_result = mysql_query($req,$connexion) ;
				$livre = mysql_fetch_array($mysql_result);
				
				$req="select * from auteurs where id=".$livre['idAuteur'];
				$mysql_result2 = mysql_query($req,$connexion) ;
				$auteur = mysql_fetch_array($mysql_result2);
	
				$req="select * from editeurs where id=".$livre['idEditeur'];
				$mysql_result2 = mysql_query($req,$connexion) ;
				$editeur = mysql_fetch_array($mysql_result2);
	
				require 'fiche.php';
				}
			else
			if ($i<8)
				{
				if ($i==2) echo "<hr>Autres suggestions : <br>";
				$req="select * from livres where id=".secure($k);
				$mysql_result = mysql_query($req,$connexion) ;
				$livre = mysql_fetch_array($mysql_result);
				if ($livre['couverture']!="")
					{
					?>
					<a href="/index.php?livre=<?=$k?>#recherche"><img src="<?=vignette2("/data/".$livre['couverture'],100,100)?>" title="<?=$livre['titre']?> <?=$livre['sousTitre']?>"></a>
					<?
					}
				}
			else
				break;
			}

		}
	
	die();
	}
	
	
?>