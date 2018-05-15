<?
$req="select * from utilisateurs where id='".secure($_SESSION['user'])."' ";
$mysql_result = mysql_query($req,$connexion) ;
$coo = mysql_fetch_array($mysql_result);

$ddn=dateen2fr($coo['dateNaissance']);
if ($ddn=="30/11/1999") $ddn="";

?>
<section id="compte" class="wrapper style2 spotlights">
						<section>
							<div class="content">
								<form method="POST" action="maj_compte.php" id="Fmajcompte" enctype="multipart/form-data">
								<div class="inner">
<?
if ($_GET['maj']==1)
	{
	?>
    <a href="#" class="button">Le compte a été mis à jour.</a>
    <?
	}
?>
									<h2>Mon compte</h2>
                                    <input type="text" name="email" placeholder="Adresse e-mail" value="<?=$coo['email']?>" readonly disabled><br>
                                    <input type="text" name="prenom" placeholder="Prénom" value="<?=$coo['prenom']?>"><br>
                                    <input type="password" name="pass" placeholder="Mot de passe" value="<?=$coo['pass']?>"><br>
                                    <input type="text" name="ville" placeholder="Ville" value="<?=$coo['ville']?>"><br>
                                    <input type="text" name="pays" placeholder="Pays" value="<?=$coo['pays']?>"><br>
                                    <input type="text" name="ddn" placeholder="Date de naissance (JJ/MM/AAAA)" value="<?=$ddn?>"><br>
                                    
<?
if ($coo['avatar']!="")
	{
	?>
	<img src="<?=vignette2("/data/".$coo['avatar'],200,200)?>"><br>
    
    <input type="checkbox" id="demo-copy" name="delimage" value="1" > <label for="demo-copy">Effacer cette image</label><br><br>
    <?
	}
?>
                  Avatar : <input name="image" type="file">                                    
                                    
                                    <br><br>
									<ul class="actions">
										<li><a href="javascript:valide_form('Fmajcompte');" class="button">Valider</a></li>
									</ul>
                                    <br><br>
								</div>
								</form>
							</div>
						</section>
					</section>