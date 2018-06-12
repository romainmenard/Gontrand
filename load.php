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
switch( $val ) {
	
	case 'entrees-sorties' : include 'load_entrees_sorties.php'; break;
	case 'statut-materiel' : include 'load_statut_materiel.php'; break;
	case 'gestion-entrees-sorties' : include 'load_gestion_entrees_sorties.php'; break;
	case 'gestion-materiel' : include 'load_gestion_materiel.php'; break;
	case 'gestion-personnel' : include 'load_gestion_personnel.php'; break;
	case 'config' : include 'load_config.php'; break;
	case 'exports' : include 'load_exports.php'; break;
	
}
?>