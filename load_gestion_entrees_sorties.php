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
if( $_SESSION['logged'] == true ) { ?>

<table id="table-<?php echo $val; ?>">

	<thead>
		<tr>
			<td>ID</td>
			<td>Code Matériel</td>
			<td>Nom Matériel</td>
			<td>Code Personne</td>
			<td>Nom Personne</td>
			<td>Date</td>
			<td>Supprimer</td>
		</tr>
	</thead>
	
	<tbody>
			
		<?php 
		$suf = 'entrees_sorties';
		$req = $bdd->query("SELECT * FROM $pre$suf ORDER BY date DESC LIMIT 0,500");
		while($data = $req->fetch()) {

		
			$id = $data['id'];
			$code_materiel = $data['code_materiel'];
			$nom_materiel = '-';
			$suf_materiel = 'materiel';
			$req_materiel = $bdd->query("SELECT * FROM $pre$suf_materiel WHERE code='$code_materiel'");
			while($data_materiel = $req_materiel->fetch()) { $nom_materiel = $data_materiel['nom']; }
			$code_personne = $data['code_personne'];
			$nom_personne = '-';
			$suf_personne = 'personnes';
			$req_personne = $bdd->query("SELECT * FROM $pre$suf_personne WHERE code='$code_personne'");
			while($data_personne = $req_personne->fetch()) { $nom_personne = $data_personne['nom']; }
			$date = 'Le '.date('d/m/Y', $data['date']).' à '.date('H:i', $data['date']);
			?>
				
			<tr>
				<td><?php echo $id; ?></td>
				<td><?php echo $code_materiel; ?></td>
				<td><?php echo $nom_materiel; ?></td>
				<td><?php echo $code_personne; ?></td>
				<td><?php echo $nom_personne; ?></td>
				<td><?php echo $date; ?></td>
				<td><a href="javascript:if(confirm('Confirmer la suppression ?')) { suppr('gestion-entrees-sorties','<?php echo $id; ?>') }">Supprimer</a></td>
			</tr>			
			
		<?php } ?>
		
	</tbody>
	
</table>

<?php } ?>