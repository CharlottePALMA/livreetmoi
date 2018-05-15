<script>
function cherche_livre()
{
	$("#ajout_bib").hide();
	$("#soumettre").hide();

	r=$("#search_livre").val();
	$.ajax({
	  type: "POST",
	  url: "ajax.php",
	  data: { action:'cherche', r:r }
	}).done(function( msg ) {
			$( "#resultat" ).html(msg);
			});
			
}

function ajoute_biblio(id)
{
$("#idLivre").val(id);
$(".plus").hide();
$(".plus2").hide();
$("#ALI"+id).show();
$("#ajout_bib").show("slow");
}

function maj_etoile(i)
{
$("#idEtoile").val(i);
for (j=1;j<=i;j++)
	$("#E"+j).css("color","#FF0");
for (j=i+1;j<=5;j++)
	$("#E"+j).css("color","#aaa");
}

function change_type(i)
{
if (i==1)
	$("#detailLivre").show("slow");
else
	$("#detailLivre").hide("slow");
}

function soumettre_livre()
{
$("#soumettre").show("slow");
}

</script>
<section id="biblio" class="wrapper style3 spotlights">
    <section>
        <div class="content">
            <div class="inner">
<?
if ($_POST['quoi']=="soumettre")
	{
	?>
    <a href="#" class="button icon fa-check-circle">Merci pour votre proposition. Elle sera validée dès que possible.</a>
    <br><br><br><br>
    <?
	}
?>
                <h2>Ma bibliothèque</h2>
                <p><span class="fa fa-search" style="margin-right:20px; color:#312450; font-size:30px; "></span>
                <input type="text" placeholder="Rechercher un livre" id="search_livre" onKeyUp="javascript:cherche_livre();" style="width:90%; display:inline; color:#fff;">
                </p>
                <p id="resultat"></p>
                
                <form action="index.php#biblio" id="ajout_bib" style="display:none;" method="post">
                <input type="hidden" name="quoi" value="ajout_biblio">
                <input type="hidden" name="idLivre" id="idLivre">
                <input type="hidden" name="etoile" id="idEtoile" >
				
                <input type="radio" id="T1" name="type" checked="" value="1" onClick="javascript:change_type(1);">
                <label for="T1">J'ai lu ce livre</label>
                
                <input type="radio" id="T2" name="type" value="2" onClick="javascript:change_type(2);">
                <label for="T2">Je suis entrain de lire</label>

                <input type="radio" id="T3" name="type" value="3" onClick="javascript:change_type(3);">
                <label for="T3">Je souhaite le lire</label>
                <br>
                <span id="detailLivre">
                    Votre note : <span class="fa fa-square etoile" onMouseOver="javascript:maj_etoile(0);" id="E0" style="color:rgba(165,70,188,1.00)"></span>
                    <span class="fa fa-star etoile" onMouseOver="javascript:maj_etoile(1);" id="E1"></span>
                    <span class="fa fa-star etoile" onMouseOver="javascript:maj_etoile(2);" id="E2"></span>
                    <span class="fa fa-star etoile" onMouseOver="javascript:maj_etoile(3);" id="E3"></span>
                    <span class="fa fa-star etoile" onMouseOver="javascript:maj_etoile(4);" id="E4"></span>
                    <span class="fa fa-star etoile" onMouseOver="javascript:maj_etoile(5);" id="E5"></span>
                    <br>
                    <textarea placeholder="Qu'avez-vous pensé de ce livre ..." name="texte"></textarea>
                    <br><br>
                </span>
				<a href="javascript:valide_form('ajout_bib');" class="button">Valider l'ajout dans ma bibliothèque</a></li>
                <br><br><br>
                </form>
                
                <ul class="actions">
                    <li><span class="fa fa-bookmark-o" style="margin-right:20px; color:#312450; font-size:30px; "></span>
                    <h7 class="button">Les livres que j'ai lu</h7></li>
                    <br style="clear:both;"><br>
<?
	$req="select * from bibliotheque where idUtilisateur=".secure($_SESSION['user'])." and etat=1 order by id ";
	$res=mysql_query($req,$connexion);
	while ($rep=mysql_fetch_array($res))
		{
		$req="select * from livres where id=".secure($rep['idLivre']);
		$mysql_result = mysql_query($req,$connexion) ;
		$livre = mysql_fetch_array($mysql_result);
		?>
		<a href="/choix.php?id=<?=$livre['id']?>" data-fancybox-type="iframe" class="fancy"><img src="<?=vignette2("/data/".$livre['couverture'],100,100)?>" title="<?=$livre['titre']?> <?=$livre['sousTitre']?> <?=$livre['tome']?>" class="ombreNoire" style="border:none;"></a>&nbsp;&nbsp;
		<?
		}
?>
                    <br><br>
                    <li><span class="fa fa-bookmark-o" style="margin-right:20px; color:#312450; font-size:30px; "></span>
                    <h7 class="button">Les livres que je suis entrain de lire</h7></li>
                    <br style="clear:both;"><br>
<?
	$req="select * from bibliotheque where idUtilisateur=".secure($_SESSION['user'])." and etat=2 order by id ";
	$res=mysql_query($req,$connexion);
	while ($rep=mysql_fetch_array($res))
		{
		$req="select * from livres where id=".secure($rep['idLivre']);
		$mysql_result = mysql_query($req,$connexion) ;
		$livre = mysql_fetch_array($mysql_result);
		?>
		<a href="/choix.php?id=<?=$livre['id']?>" data-fancybox-type="iframe" class="fancy"><img src="<?=vignette2("/data/".$livre['couverture'],100,100)?>" title="<?=$livre['titre']?> <?=$livre['sousTitre']?> <?=$livre['tome']?>" class="ombreNoire" style="border:none;"></a>&nbsp;&nbsp;
		<?
		}
?>
                    <br><br>
                    <li><span class="fa fa-bookmark-o" style="margin-right:20px; color:#312450; font-size:30px; "></span>
                    <h7 class="button">Les livres que je souhaite lire</h7></li>
                    <br style="clear:both;"><br>
<?
	$req="select * from bibliotheque where idUtilisateur=".secure($_SESSION['user'])." and etat=3 order by id ";
	$res=mysql_query($req,$connexion);
	while ($rep=mysql_fetch_array($res))
		{
		$req="select * from livres where id=".secure($rep['idLivre']);
		$mysql_result = mysql_query($req,$connexion) ;
		$livre = mysql_fetch_array($mysql_result);
		?>
		<a href="/choix.php?id=<?=$livre['id']?>" data-fancybox-type="iframe" class="fancy"><img src="<?=vignette2("/data/".$livre['couverture'],100,100)?>" title="<?=$livre['titre']?> <?=$livre['sousTitre']?> <?=$livre['tome']?>" class="ombreNoire" style="border:none;"></a>&nbsp;&nbsp;
		<?
		}
?>
                    <br><br>
                    <li><span class="fa fa-bookmark-o" style="margin-right:20px; color:#312450; font-size:30px; "></span>
                    <a href="javascript:soumettre_livre();" class="button">Proposer un livre</a></li>

				<form action="index.php#biblio" id="soumettre" style="display:none;" method="post">
                <input type="hidden" name="quoi" value="soumettre">
                	<br>
					<input type="text" name="titre" placeholder="Titre du Livre">
                    <br>
					<input type="text" name="sousTitre" placeholder="Sous-Titre du Livre">
                    <br>
					<input type="text" name="auteur" placeholder="Auteur">
                    <br>
                    <input type="text" name="editeur" placeholder="Editeur">
                    <br>
                    <input type="text" name="collection" placeholder="Collection">
                    <br>
                    <textarea placeholder="Qu'avez-vous pensé de ce livre ..." name="texte"></textarea>
                    <br><br>
				<a href="javascript:valide_form('soumettre');" class="button">Valider la proposition</a></li>
                <br><br><br>
                </form>

                </ul>
            </div>
        <br><br><br><br><br><br>    
        </div>
    </section>
</section>