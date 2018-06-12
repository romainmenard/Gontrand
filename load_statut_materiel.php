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

<table id="table-<?php echo $val; ?>">

	<thead>
		<tr>
			<td>ID</td>
			<td>Code</td>
			<td>Code interne</td>
			<td>Nom</td>
			<td>Statut</td>
		</tr>
	</thead>
	
	<tbody>
			
		<?php 
		$suf = 'materiel';
		$req = $bdd->query("SELECT * FROM $pre$suf ORDER BY nom ASC");
		while($data = $req->fetch()) {

			$code_personne = '';
			$nom_personne = '-';
		
			$id = $data['id'];
			$nom = $data['nom'];
			$code = $data['code'];
			$code_interne = $data['code_interne'];
			
			$nom_statut = 'undefined';
			$suf_statut = 'entrees_sorties';
			$req_statut = $bdd->query("SELECT * FROM $pre$suf_statut WHERE code_materiel = '$code' ORDER BY date DESC LIMIT 0,1");
			while( $data_statut = $req_statut->fetch() ) {
				
				$code_personne = $data_statut['code_personne'];
				
			}
				
			$suf_personne = 'personnes';
			$req_personne = $bdd->query("SELECT * FROM $pre$suf_personne WHERE code = '$code_personne'");
			while( $data_personne = $req_personne->fetch() ) {
				
				$nom_personne = $data_personne['nom'];
				
			}
			?>
				
			<tr id="<?php echo $val.'-'.$id; ?>">
				<td><?php echo $id; ?></td>
				<td><?php echo $code; ?></td>
				<td><?php echo $code_interne; ?></td>
				<td><?php echo $nom; ?></td>
				<td><?php echo $nom_personne; ?></td>
			</tr>			
			
		<?php } ?>
		
	</tbody>
	
</table>