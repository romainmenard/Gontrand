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

<table>

	<thead>
		<tr>
			<td>Les exports du plus récent au plus ancien</td>
			<td>Consulter</td>
			<td>Télécharger</td>
			<td>Supprimer</td>
		</tr>
	</thead>
	
	<tbody>
			
		<?php
		$dir = scandir('exports');
		$dir = array_reverse($dir);
		foreach( $dir as $file ) { 

			if( $file != '.' AND $file != '..' AND $file != 'index.php' ) { ?>

				<tr>
					<td><?php echo $file; ?></td>
					<td><a href="exports/<?php echo $file; ?>" target="_blank">Consulter</a></td>
					<td><a href="exports/<?php echo $file; ?>" download>Télécharger</a></td>
					<td><a href="javascript:if(confirm('Confirmer la suppression ?')) { suppr('exports','<?php echo $file; ?>') }">Supprimer</a></td>
				</tr>
			
			<?php }

		}
		?>
		
	</tbody>

</table>