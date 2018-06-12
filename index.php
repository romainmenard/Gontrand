<?php /*
Copyright (C) 2018 Ménard Romain

This file is part of Gontrand.

Gontrand is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Gontrand is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Gontrand.  If not, see <http://www.gnu.org/licenses/>
*/ ?>

<?php 
session_start();
if( isset( $_SESSION['logged'] ) ) {
$is_admin = ( $_SESSION['logged'] == true ) ? 1 : 0;
} else { $is_admin = 0; }
if( isset( $_GET['install_done'] ) ) { unlink('install.php'); }
if( !file_exists('config.php') ) { header('Location:install.php'); exit(0); }
?>

<!doctype html>
<html>
<head>
	
	<meta charset="utf-8"/>
	<title>Gontrand - Gestion des entrées / sorties</title>
	<script src="jquery.js"></script>
	<link href="style.css" rel="stylesheet"/>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700" rel="stylesheet">
	<link rel="icon" href="favicon.png"/>
	
</head>
<body>

	<nav id="main-nav">
	
		<h1>Gontrand</h1>
	
		<ul>
			<li><a href="javascript:showTab('entrees-sorties')">Entrées / Sorties</a></li>
			<li><a href="javascript:showTab('statut-materiel')">Statut du matériel</a></li>
			<li><a href="dernier-export.html" target="_blank">Voir le dernier export</a></li>
			<li>---</li>
			<?php if( $is_admin == 1 ) { ?>
			<li><a href="javascript:showTab('gestion-entrees-sorties')">Gérer les entrées /sorties</a></li>
			<li><a href="javascript:showTab('gestion-materiel')">Gérer le matériel</a></li>
			<li><a href="javascript:showTab('gestion-personnel')">Gérer le personnel</a></li>
			<li><a href="javascript:showTab('exports')" target="_blank">Gérer les exports statiques</a></li>
			<li><a href="javascript:showTab('config')">Configurer Gontrand</a></li>
			<li>---</li>
			<li><a href="javascript:logout()">Déconnexion</a></li>
			<?php } else { ?>
			<li><a href="javascript:showTab('login')">Administrer Gontrand</a></li>
			<?php } ?>
		</ul>
	
	</nav>

	<div id="entrees-sorties-tab" class="tab">
		
		<h2>Historique des entrées / sorties</h2>

		<form id="scan-form">
					
			<h3>Ajouter une entrée ou sortie</h3>
		
			<div class="field">			
				<p>
					<label for="es-code-materiel">Code matériel</label><br/>
					<input type="text" name="code_materiel" id="es-code-materiel"/>
				</p>			
			</div>
		
			<div class="field">
				<p>
					<label for="es-code-personne">Code personne</label><br/>
					<input type="text" name="code_personne" id="es-code-personne"/>
				</p>			
			</div>
		
			<div class="field" style="position:absolute; left:-900px">			
				<p>
					<label for="es-code-validation">Code validation</label><br/>
					<input type="text" name="code_validation" id="es-code-validation"/>
				</p>			
			</div>
		
			<div class="field" style="position:absolute; left:-900px">
				<p><input type="submit" value="Valider"/></p>				
			</div>
		
			<div class="field">
				<p class="encart">Pour valider la saisie, merci de scanner le code de validation</p>				
			</div>
			
		</form>
		
		<h3>Historique</h3>
		<div class="data"></div>
		
	</div>

	<div id="statut-materiel-tab" class="tab" style="display:none">
		
		<h2>Statut du matériel</h2>
		<div class="data"></div>
		
	</div>
	
	<?php if( $is_admin == 1 ) { ?>
	
		<div id="isadmin"></div>
		
		<div id="gestion-entrees-sorties-tab" class="tab" style="display:none">
			
			<h2>Gestion des entrées / sorties</h2>

			<h3>Historique</h3>
			<div class="data"></div>
			
		</div>
	
		<div id="gestion-materiel-tab" class="tab" style="display:none">
				
			<h2>Gestion du matériel</h2>
			
			<form id="materiel-form" class="add">
						
				<h3>Ajouter un matériel</h3>
			
				<div class="field">				
					<p>
						<label for="code-materiel">Code matériel</label><br/>
						<input type="text" name="code" id="code-materiel"/>
					</p>				
				</div>
				<div class="field">				
					<p>
						<label for="code-interne">Code interne</label><br/>
						<input type="text" name="code_interne" id="code-interne"/>
					</p>				
				</div>			
				<div class="field">				
					<p>
						<label for="nom-materiel">Nom matériel</label><br/>
						<input type="text" name="nom" id="nom-materiel"/>
					</p>				
				</div>			
				<div class="field">				
					<p>
						<input type="hidden" name="val" value="gestion-materiel"/>
						<input type="submit"/>
					</p>					
				</div>
				
			</form>
			
			<div class="data"></div>
		
		</div>
	
		<div id="gestion-personnel-tab" class="tab" style="display:none">
				
			<h2>Gestion du personnel</h2>
			
			<form id="personnes-form" class="add">
						
				<h3>Ajouter une personne</h3>
				
				<div class="field">				
					<p>
						<label for="code-personne">Code personne</label><br/>
						<input type="text" name="code" id="code-personne"/>
					</p>				
				</div>			
				<div class="field">				
					<p>
						<label for="nom-personne">Nom personne</label><br/>
						<input type="text" name="nom" id="nom-personne"/>
					</p>				
				</div>			
				<div class="field">				
					<p>
						<input type="hidden" name="val" value="gestion-personnel"/>
						<input type="submit"/>
					</p>					
				</div>
				
			</form>
			
			<div class="data"></div>
		
		</div>
	
		<div id="exports-tab" class="tab" style="display:none">
				
			<h2>Gestion des exports statiques</h2>
			<p><a class="button" href="javascript:export_datas()">Exporter les données</a></p>
			<div class="data"></div>
		
		</div>

		<div id="config-tab" class="tab" style="display:none">
			
			<h2>Configuration de Gontrand</h2>
			<form id="config-form" class="add">
	
				<h3>Mot de passe</h3>
				
				<div class="field">				
					<p>
						<label for="mdp1">Saisir le mot de passe</label><br/>
						<input type="password" name="mdp1" id="mdp1"/>
					</p>				
				</div>

				<div class="field">				
					<p>
						<label for="mdp2">Confirmer le mot de passe</label><br/>
						<input type="password" name="mdp2" id="mdp2"/>
					</p>				
				</div>

				<div class="field">				
					<p>
						<input type="hidden" name="val" value="config"/>
						<input type="submit"/>
					</p>					
				</div>
				
			</form>

			<form id="validation-form" class="add">
				
				<h3>Code de validation du formulaire entrées / sorties</h3>
								
				<div class="field">				
					<p>
						<label for="code-validation">Saisir le code</label><br/>
						<input type="text" name="code_validation" id="code-validation" value=""/>
					</p>				
				</div>
				
				<div class="field">				
					<p>
						<input type="hidden" name="val" value="validation"/>
						<input type="submit"/>
					</p>					
				</div>
				
			</form>
					
				
		</div>
		
	<?php } else { ?>

		<div id="login-tab" class="tab" style="display:none">
			
			<h2>Administration</h2>
		
			<form id="login-form" class="add">
				
				<h3>Saisissez le mot de passe pour vous connecter en tant qu'administrateur</h3>
				
				<div class="field">
				
					<p>
						<label for="mdp">Mot de passe</label><br/>
						<input type="password" name="mdp" id="mdp"/>
					</p>
				
				</div>
				
				<div class="field">
				
					<p>
						<input type="hidden" name="val" value="config"/>
						<input type="submit"/>
					</p>
					
				</div>
				
			</form>
				
		</div>
		
	<?php } ?>

	<script src="scripts.js"></script>
		
</body>
</html>