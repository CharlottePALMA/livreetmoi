<section id="recherche" class="wrapper style1 fullscreen fade-up">

	<a id="recherche" href="/index.php?a=<?=time(NULL)?>#recherche">
    	<span class="fa fa-repeat" style="margin-left:20px; color: rgba(163,163,163,1.00); font-size:30px; font-family:""></span> recommencer
    </a>
    <div class="inner" id="divQuestion" style="text-align:center">
    
<?
if (!isset($_GET['livre']))
	{
	$req="select * FROM questions WHERE id=".$question;		
	$res=mysql_query($req,$connexion);
	$rep=mysql_fetch_array($res);
	?>
    
        <h1><?=$rep['question']?></h1>
        <p><? 
                            
        for ($i=1;$i<=15;$i++)
            {
            if ($rep['rep'.$i]!="")
                {
                ?> 
                <a class="st<?=$rep['id']?>_<?=$i?> lien" href="javascript:ma_reponse(<?=$rep['id']?>,<?=$i?>);"><?=str_replace(" ","&nbsp;",$rep['rep'.$i])?></a>
                <?	
                }
            }
    
                                
         ?></p>
                            
	<?
	}
else
	{
	$k=$_GET['livre'];
	
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

	$i=0;
	foreach ($_SESSION['note'] as $k => $v)
		{
		$i++;
		if ($i==1)
			echo "<hr>Autres suggestions : <br>";
		if ($i<8)
			{
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
		}

	}
?>

    </div>
</section>
