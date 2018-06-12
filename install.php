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
*/
session_start();
if( isset( $_SESSION['logged'] ) ) {
$is_admin = ( $_SESSION['logged'] == true ) ? 1 : 0;
} else { $is_admin = 0; }
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
			<li>Version 1.0</li>
			<li>GNU GPL version 3</li>
		</ul>
	
	</nav>

	<div id="entrees-sorties-tab" class="tab">
		
		<h2>Installer Gontrand</h2>
		
		<?php if( isset( $_POST['bdd_host'] ) ) {
			
			$errors = array();
		
			$bdd_host = $_POST['bdd_host'];
			$bdd_name = $_POST['bdd_name'];
			$bdd_user = $_POST['bdd_user'];
			$bdd_pass = $_POST['bdd_pass'];
			$bdd_pref = $_POST['bdd_pref'];
			$mdp1 = $_POST['mdp1'];
			$mdp2 = $_POST['mdp2'];
			
			if( $mdp1 != $mdp2 ) {
				
				$errors[] = 'Les deux mots de passe diffèrent.';
				
			} else {
				
				$mdp = sha1($mdp1);
				
			}
			
			$code = $_POST['code'];
			
			try { $bdd = new PDO('mysql:host='.$bdd_host.';dbname='.$bdd_name.';charset=utf8', $bdd_user, $bdd_pass); }
			catch (Exception $e) { $errors[] = 'Problème de connexion à la base de données.'; }
		
			if( count($errors) == 0 ) {
			
				$bdd->exec("CREATE TABLE `".$bdd_pref."entrees_sorties` (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`code_materiel` varchar(255) NOT NULL,
				`code_personne` varchar(255) NOT NULL,
				`date` bigint(20) NOT NULL
				)");
				$bdd->exec("CREATE TABLE `".$bdd_pref."materiel` (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`code` varchar(255) NOT NULL,
				`code_interne` varchar(255) NOT NULL,
				`nom` varchar(255) NOT NULL
				)");
				$bdd->exec("CREATE TABLE `".$bdd_pref."personnes` (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`code` varchar(255) NOT NULL,
				`nom` varchar(255) NOT NULL
				)");
				$bdd->exec("CREATE TABLE `".$bdd_pref."settings` (
				`password` varchar(255) NOT NULL,
				`code_validation` varchar(255) NOT NULL,
				`type_validation` varchar(255) NOT NULL
				)");
				$bdd->exec("INSERT INTO `".$bdd_pref."settings` (`password`, `code_validation`, `type_validation`) VALUES ('".$mdp."', '".$code."', 0)");
				
				$data = '<?php $pre=\''.$bdd_pref.'\'; try { $bdd = new PDO(\'mysql:host='.$bdd_host.';dbname='.$bdd_name.';charset=utf8\', \''.$bdd_user.'\', \''.$bdd_pass.'\'); } catch (Exception $e) {  die(\'Erreur : \' . $e->getMessage()); } ?>';
				touch('config.php');
				$file = fopen('config.php','w');
				fwrite($file, $data);
				fclose($file);
				?>
			
				<h3>Gontrand est installé. Le toupet de Donald Trump est sauf !</h3>
				<p>Pour votre sécurité, en cliquant sur le lien ci-dessous, vous allez engendrer la suppression du fichier d'installation.</p>
				<p><a href="index.php?install_done">Finaliser l'installation et retourner à la page principale</a></p>
				
			<?php } else { ?>
			
				<h3>Un problème est survenu</h3>
				<?php foreach($errors as $error) { echo '<p>'.$error.'</p>'; } ?>
				<p>Résultat : Internet est tout cassé, et Donald Trump officiellement chauve.</p>
				<p><a href="install.php">Retenter ma chance</a></p>
			
			<?php } ?>
			
		<?php } else { ?>

			<h3>Pourquoi Gontrand ?</h3>
			<p>Parce qu'on peut.</p>

			<form id="install" class="install-form" action="" method="post">
				
				<h3>Informations de connexion à la base de données</h3>
				
				<div class="field">			
					<p>
						<label for="bdd-host">Hôte (adresse)</label><br/>
						<input type="text" name="bdd_host" id="bdd-host" value="localhost"/>
					</p>			
				</div>
				
				<div class="field">			
					<p>
						<label for="bdd-name">Nom de la base</label><br/>
						<input type="text" name="bdd_name" id="bdd-name"/>
					</p>			
				</div>
				
				<div class="field">			
					<p>
						<label for="bdd-user">Utilisateur</label><br/>
						<input type="text" name="bdd_user" id="bdd-user"/>
					</p>			
				</div>
				
				<div class="field">			
					<p>
						<label for="bdd-pass">Mot de passe</label><br/>
						<input type="password" name="bdd_pass" id="bdd-pass"/>
					</p>			
				</div>
				
				<div class="field">			
					<p>
						<label for="bdd-pref">Préfixe de table</label><br/>
						<input type="text" name="bdd_pref" id="bdd-pref" value="gntrnd_"/>
					</p>			
				</div>

				<h3>Mot de passe administrateur</h3>
				<p>Vous pourrez le modifier, mais vous en aurez besoin pour votre première connexion. Alors ne le perdez pas !</p>
				
				<div class="field">			
					<p>
						<label for="mdp1">Mot de passe</label><br/>
						<input type="password" name="mdp1" id="mdp1"/>
					</p>			
				</div>
				
				<div class="field">			
					<p>
						<label for="mdp2">Confirmez le mot de passe</label><br/>
						<input type="password" name="mdp2" id="mdp2"/>
					</p>			
				</div>
				
				<h3>Code de validation</h3>
				<p>Les usagers devront scanner un code de validation pour confirmer leur saisie. Vous pourrez le renseigner plus tard !</p>
			
				<div class="field">			
					<p>
						<label for="code">Saisissez le code de validation</label><br/>
						<input type="password" name="code" id="code"/>
					</p>			
				</div>

				<h3>On peut y aller ?</h3>
				<p>En cliquant sur le bouton ci-dessous : si les informations sont exactes, Gontrand sera installé et prêt à être utilisé ; si les informations sont inexactes, vous risquez de casser Internet et faire tomber le toupet de Donald Trump.</p>
			
				<div class="field">			
					<p>					
						<input type="submit" value="C'est parti !"/>
					</p>			
				</div>
												
			</form>
			
		<?php } ?>
		
	</div>
		
</body>
</html>