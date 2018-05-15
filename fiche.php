	<h1 class="titre"><?=$livre['titre']?></h1>

            <h2><?=$livre['sousTitre']?>
            <?
			if (trim($livre['tome'])!="") echo " - Tome ".$livre['tome'];
			?>
            </h2>
            <h2><?=$auteur['prenom']?> <?=$auteur['nom']?></h2>

            <h3>Editeur : <?=$editeur['nom']?><h3>
            <br>
            
            <?
			// on affiche la couverture du livre
			if ($livre['couverture']!="")
				{
				?>
				<a href="/data/<?=$livre['couverture']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$livre['couverture'],300,400)?>" align="left" class="ombre"></a>
				<?
				}
			?>
            
            <?=$livre['resume']?>
            <br>
            
            <?
			// on affiche la photo de l'auteur
			if ($auteur['photo']!="")
				{
				?>
				<a href="/biographie.php?id=<?=$auteur['id']?>" data-fancybox-type="iframe" class="fancy"><img src="<?=vignette2("/data/".$auteur['photo'],200,200)?>" title="<?=$auteur['prenom']?> <?=$auteur['nom']?>" class="ombre"></a>&nbsp;&nbsp;
				<?
				}
			?>

            <?
			if ($editeur['logo']!="")
				{
				?>
				<a href="/data/<?=$editeur['logo']?>" data-fancybox-type="image" class="fancy"><img src="<?=vignette2("/data/".$editeur['logo'],200,200)?>" title="<?=$editeur['nom']?>" class="ombre"></a>
				<?
				}
			?>
            
            <?
			// La note du livre
			$note=0;
			$nbn=0;
			$req="select * from bibliotheque where idLivre=".$livre['id']; 
			$mysql_result9 = mysql_query($req,$connexion) ;
			while ($ligne9 = mysql_fetch_array($mysql_result9))
				{
				$nbn++;
				$note+=$ligne9['note'];
				}
			if ($nbn>0)
				$note=round($note/$nbn);
			else
				$note=3;

			// La note de l'auteur
			$noteA=0;
			$nbnA=0;
			$req="select * from bibliotheque where idAuteur=".$auteur['id']; 
			$mysql_result9 = mysql_query($req,$connexion) ;
			while ($ligne9 = mysql_fetch_array($mysql_result9))
				{
				$nbnA++;
				$noteA+=$ligne9['note'];
				}
			if ($nbnA>0)
				$noteA=round($noteA/$nbnA);
			else
				$noteA=3;
			
			?>
            <br><br>
			<h3>L'avis des lecteurs de Livre-et-moi.fr</h3>
            Note du livre :
            <?
			for ($j=1;$j<=$note;$j++)
				{
				?>
                <span class="fa fa-star etoile" style="color:#FF0"></span>
                <?
				}
			for ($j=$note+1;$j<=5;$j++)
				{
				?>
                <span class="fa fa-star etoile" style="color:#AAA"></span>
                <?
				}	
			?>		
            
            &nbsp;&nbsp;&nbsp;
            
            Note de l'auteur :
            <?
			for ($j=1;$j<=$noteA;$j++)
				{
				?>
                <span class="fa fa-star etoile" style="color:#FF0"></span>
                <?
				}
			for ($j=$noteA+1;$j<=5;$j++)
				{
				?>
                <span class="fa fa-star etoile" style="color:#AAA"></span>
                <?
				}	


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

            
            