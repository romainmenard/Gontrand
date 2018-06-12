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
			<td>Nom</td>
			<td>Modifier</td>
			<td>Supprimer</td>
		</tr>
	</thead>
	
	<tbody>
			
		<?php 
		$suf = 'personnes';
		$req = $bdd->query("SELECT * FROM $pre$suf ORDER BY nom ASC");
		while($data = $req->fetch()) { 

			$id = $data['id'];
			$nom = $data['nom'];
			$code = $data['code'];
			?>
				
			<tr id="gestion-personnel-<?php echo $id; ?>">
				<td><?php echo $id; ?></td>
				<td><input type="text" name="edit-gestion-personnel-code" value="<?php echo $code; ?>"/></td>
				<td><input type="text" name="edit-gestion-personnel-nom" value="<?php echo $nom; ?>"/></td>
				<td><a href="javascript:edit('gestion-personnel','<?php echo $id; ?>')">Modifier</a></td>
				<td><a href="javascript:if(confirm('Confirmer la suppression ?')) { suppr('gestion-personnel','<?php echo $id; ?>') }">Supprimer</a></td>
			</tr>			
			
		<?php } ?>
		
	</tbody>
	
</table>