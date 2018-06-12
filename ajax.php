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
include 'config.php';

$action = $_POST['action'];

switch($action) {
	
	case 'add' :
	
		$val = $_POST['val'];
		
		switch($val) {
			
			case 'gestion-materiel' :
			
				$nom = $_POST['nom'];
				$code = $_POST['code'];
				$code_interne = $_POST['code_interne'];
				$suf = 'materiel';
				$bdd->query("INSERT INTO $pre$suf VALUES('','$code','$code_interne','$nom')");
			
			break;
			
			case 'gestion-personnel' :
			
				$nom = $_POST['nom'];
				$code = $_POST['code'];
				$suf = 'personnes';
				$bdd->query("INSERT INTO $pre$suf VALUES('','$code','$nom')");
			
			break;
			
		}
	
	break;
	
	case 'add_entree_sortie' :
	
		$code_materiel = $_POST['code_materiel'];
		$code_personne = $_POST['code_personne'];
		
		$error = '';
		
		$suf = 'materiel';
		$req = $bdd->query("SELECT * FROM $pre$suf WHERE code = '$code_materiel'");
		if( $req->rowCount() == 0 ) { $error = 'Ce code ne correspond à aucun matériel enregistré.'; }
		
		$suf = 'personnes';
		$req = $bdd->query("SELECT * FROM $pre$suf WHERE code = '$code_personne'");
		if( $req->rowCount() == 0 ) { $error = 'Ce code ne correspond à aucun personnel enregistré.'; }
		
		if( $error == '' ) {
			
			$date = time();			
			$suf = 'entrees_sorties';
			$bdd->query("INSERT INTO $pre$suf VALUES('','$code_materiel','$code_personne','$date')");
		
		} else {
			
			echo $error;
			
		}
	
	break;
	
	case 'suppr' :
	
		$val = $_POST['val'];
		$id = $_POST['id'];
		
		switch($val) {
			
			case 'gestion-materiel' :
			
				$suf = 'materiel';
				$bdd->query("DELETE FROM $pre$suf WHERE id='$id'");
			
			break;
			
			case 'gestion-personnel' :
			
				$suf = 'personnes';
				$bdd->query("DELETE FROM $pre$suf WHERE id='$id'");
			
			break;
			
			case 'gestion-entrees-sorties' :
			
				$suf = 'entrees_sorties';
				$bdd->query("DELETE FROM $pre$suf WHERE id='$id'");
			
			break;
			
			case 'exports' :
			
				unlink('exports/'.$id);
			
			break;
			
		}
		
	break;
	
	case 'edit' :
	
		$val = $_POST['val'];
		$id = $_POST['id'];
		
		switch($val) {
		
			case 'gestion-materiel' :
			
				$suf = 'materiel';
				$req = $bdd->query("SELECT * FROM $pre$suf WHERE id='$id'");
				while($data = $req->fetch()) {
					
					$current_code = $data['code'];
					
				}
			
				$nom = $_POST['nom'];
				$code = $_POST['code'];
				$code_interne = $_POST['code_interne'];
				$bdd->query("UPDATE $pre$suf SET nom='$nom', code='$code', code_interne='$code_interne' WHERE id='$id'");
				$field = 'code_materiel';
			
			break;
			
			case 'gestion-personnel' :
			
				$suf = 'personnes';
				$req = $bdd->query("SELECT * FROM $pre$suf WHERE id='$id'");
				while($data = $req->fetch()) {
					
					$current_code = $data['code'];
					
				}
				$nom = $_POST['nom'];
				$code = $_POST['code'];
				$bdd->query("UPDATE $pre$suf SET nom='$nom', code='$code' WHERE id='$id'");
				$field = 'code_personne';
			
			break;	
			
		}

		$suf = 'entrees_sorties';
		$bdd->query("UPDATE $pre$suf SET $field='$code' WHERE $field='$current_code'");
	
	break;
	
	case 'load' :
	
		$val = $_POST['val'];
		include 'load.php';
	
	break;
	
	case 'export' :
	
		$css = file_get_contents('style.css');
		$js = file_get_contents('scripts.js');
		$jquery = file_get_contents('jquery.js');
		$entrees_sorties_data = $_POST['entrees_sorties_data'];
		$materiel_data = $_POST['materiel_data'];
		
		include 'export.php';
		
		$filename = 'export-'.date('d-m-y-H-i-s').'.html';
		
		@unlink('dernier-export.html');
		$filename2 = 'dernier-export.html';
		
		touch('exports/'.$filename);
		$file = fopen('exports/'.$filename,'w');
		fwrite($file, $html);
		fclose($file);
		
		touch($filename2);
		$file = fopen($filename2,'w');
		fwrite($file, $html);
		fclose($file);
	
	break;
	
	case 'change_password' :
	
		$mdp = sha1($_POST['mdp1']);
		if( $mdp != '' ) {
			
			$suf = 'settings';
			$bdd->query("UPDATE $pre$suf SET password='$mdp'");
			
		}
	
	break;
	
	case 'change_code_validation' :
	
		$code_validation = $_POST['code_validation'];
		if( $code_validation != '' ) {
			
			$suf = 'settings';
			$bdd->query("UPDATE $pre$suf SET code_validation='$code_validation'");
			
		}
	
	break;
	
	case 'load_code_validation' :
	
		$suf = 'settings';
		$req = $bdd->query("SELECT * FROM $pre$suf");
		while($data = $req->fetch()){
			
			$code_validation = $data['code_validation'];
			
		}
		
		echo $code_validation;
	
	break;
	
	case 'login' :
	
		$_SESSION['logged'] = false;
		$mdp = sha1($_POST['mdp']);
		
		if( $mdp != '' ) {
			
			$suf = 'settings';
			$req = $bdd->query("SELECT * FROM $pre$suf WHERE password='$mdp'");
			if( $req->rowCount() == 0 ) {
				
				echo 'Vous n\'avez pas saisi le bon mot de passe.';
				
			} else {
				
				$_SESSION['logged'] = true;
				
			}
			
		} else {
			
			echo 'Merci de saisir un mot de passe';
			
		}
	
	break;
	
	case 'logout' :
	
		session_destroy();
	
	break;
	
}