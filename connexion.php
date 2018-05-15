<section id="one" class="wrapper style2 spotlights" style="color:#FFF">
						<section>
							<div class="content">
								<form method="POST" action="login.php" id="Flog">
								<div class="inner">
									<h2>Déjà inscrit ?</h2>
									<p><span class="fa fa-male" style="margin-right:20px; color:#FFF; font-size:30px; "></span> Connectez-vous</p>
                                    <input type="text" name="email" placeholder="Adresse e-mail"><br>
                                    <input type="password" name="pass" placeholder="Mot de passe"><br>
									<ul class="actions">
										<li><a href="javascript:valide_form('Flog');" class="button">Se connecter</a></li>
									</ul>
								</div>
                                </form>
							</div>
							<div class="content">
								<form method="POST" action="inscrire.php" id="Finsc">
								<div class="inner">
									<h2>Pas encore inscrit ?</h2>
									<p><span class="fa fa-pencil" style="margin-right:20px; color:#FFF; font-size:30px; "></span> Inscrivez-vous</p>
                                    <input type="text" name="email" placeholder="Adresse e-mail"><br>
                                    <input type="text" name="prenom" placeholder="Prénom"><br>
                                    <input type="password" name="pass" placeholder="Mot de passe"><br>
									<ul class="actions">
										<li><a href="javascript:valide_form('Finsc');" class="button">S'inscrire</a></li>
									</ul>
								</div>
								</form>
							</div>
						</section>
					</section>