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
	
	<?php 
	$suf = 'settings';
	$req = $bdd->query("SELECT * FROM $pre$suf");
	while($data = $req->fetch()){
		
		$code_validation = $data['code_validation'];
		
	}
	?>
	
	<div class="field">				
		<p>
			<label for="code-validation">Saisir le code</label><br/>
			<input type="text" name="code_validation" id="code-validation" value="<?php echo $code_validation; ?>"/>
		</p>				
	</div>
	
	<div class="field">				
		<p>
			<input type="hidden" name="val" value="validation"/>
			<input type="submit"/>
		</p>					
	</div>
	
</form>