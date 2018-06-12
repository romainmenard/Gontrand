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
$html = '<!--
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
-->';
$html .= '<!doctype html>';
$html .= '<html>';
$html .= '<head>';
$html .= '<meta charset="utf-8"/>';
$html .= '<script>'.$jquery.'</script>';
$html .= '<style>'.$css.'</style>';
$html .= '<link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700" rel="stylesheet">';
$html .= '<link rel="icon" href="favicon.png"/>';
$html .= '</head>';
$html .= '<body class="static">';
$html .= '<nav id="main-nav">';
$html .= '<h1>Gontrand</h1>';
$html .= '<ul>';
$html .= '<li style="font-size:0.8em">Export du '.date("d/m/Y", time()).' à '.date("H:i",time()).'</li>';
$html .= '<li>--</li>';
$html .= '<li><a href="javascript:showTabStatic(\'entrees-sorties\')">Entrées / Sorties</a></li>';
$html .= '<li><a href="javascript:showTabStatic(\'statut-materiel\')">Matériel</a></li>';
$html .= '</ul>';
$html .= '</nav>';
$html .= '<div id="entrees-sorties-tab" class="tab">';
$html .= '<h2>Historique des entrées / sorties</h2>';
$html .= '<h3>Historique</h3>';
$html .= '<div class="data">'.$entrees_sorties_data.'</div>';
$html .= '</div>';
$html .= '<div id="statut-materiel-tab" class="tab" style="display:none">';
$html .= '<h2>Gestion du matériel</h2>';
$html .= '<div class="data">'.$materiel_data.'</div>';
$html .= '</div>';
$html .= '</div>';
$html .= '<script>'.$js.'</script>';
$html .= '</body>';
$html .= '</html>';
?>