/*
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

function showTab(tab) {
	
	$('.tab').hide();
	load(tab);
	$('#'+tab+'-tab').show();
	
	if( tab == 'entrees-sorties' ) { $('#scan-form input[name=code_materiel]').focus(); }
	else { $('#'+tab+'-tab input[name=code]').focus(); }
	
}
function showTabStatic(tab) {
	
	$('.tab').hide();
	$('#'+tab+'-tab').show();
	
}

$(document).ready(function() {
	
	load('entrees-sorties');
	load('statut-materiel');
	$('#scan-form input[name=code_materiel]').focus();
	load_code_validation();
	load_type_validation();
	
});

$('.add').submit(function() {
	
	var form_id = $(this).attr('id');
	
	if( form_id == 'config-form' ) {
		
		var mdp1 = $('#'+form_id+' input[name=mdp1]').val();
		var mdp2 = $('#'+form_id+' input[name=mdp2]').val();
		if( mdp1 == mdp2 ) {
			
			$.post('ajax.php', {mdp1:mdp1, action:'change_password'}, function(data) {
				
				alert('Mot de passe modifié !');
				
			});
			
		} else {
			
			alert('Les deux mots de passe diffèrent');
			
		}
		
	} else if( form_id == 'validation-form' ) {

		var code_validation = $('#'+form_id+' input[name=code_validation]').val();
		var type_validation = $('#'+form_id+' select[name=type_validation]').val();
		$.post('ajax.php', {code_validation:code_validation, type_validation:type_validation, action:'options_validation'}, function(data) {
			
			if( data == '' ) {
				
				alert('Options de validation modifiées !');
				sessionStorage.setItem('code_validation',code_validation);
				if( $('#isadmin').length > 0 ) { $('#scan-form input[name=code_validation]').val( code_validation ); }
				window.location.href = '';
				
			} else {
				
				alert(data);
				
			}
			
		});
		
	} else if( form_id == 'login-form' ) {

		var mdp = $('#'+form_id+' input[name=mdp]').val();
		$.post('ajax.php', {mdp:mdp, action:'login'}, function(data) {
			
			if( data == '' ) {
				
				window.location.href = '';
				
			} else {
				
				alert(data);
				
			}
			
		});
		
	} else {
	
		var val = $('#'+form_id+' input[name=val]').val();
		var code = $('#'+form_id+' input[name=code]').val();
		var code_interne = '';
		if( form_id == 'materiel-form' ) { code_interne = $('#'+form_id+' input[name=code_interne]').val(); }
		var nom = $('#'+form_id+' input[name=nom]').val();
		
		$.post('ajax.php', {val:val, code:code, code_interne:code_interne, nom:nom, action:'add'}, function(data) {
						
			$('input[type=text]').val('');
			$('input[type=password]').val('');
			
			load(val);
			
		});
	
	}
	return false;
	
});

$('#scan-form').submit(function() {
	
	var type_validation = sessionStorage.getItem('type_validation');
	var code_materiel = $('#scan-form input[name=code_materiel]').val();
	var code_personne = $('#scan-form input[name=code_personne]').val();
	var code_validation= '';
	var error = '';
	
	if( type_validation == 0 || type_validation == 2 ) {
		
		var code_validation = $('#scan-form input[name=code_validation]').val();
	
		if( type_validation == 0 && code_validation != sessionStorage.getItem('code_validation') ) { error = 'Mauvais code de validation'; }
		if( type_validation == 2 && code_validation != '' && code_validation != sessionStorage.getItem('code_validation') ) { error = 'Mauvais code de validation'; }
	
	}
	
	if( error == '' ) {

		$.post('ajax.php', {code_materiel:code_materiel, code_personne:code_personne, action:'add_entree_sortie'}, function(data) {
			
			if( data == '' ) {
				
				$('#scan-form input[type=text]').val('');
				load('entrees-sorties');
				load('statut-materiel');
								
			} else {
				
				alert(data);
				
			}
			
		});
		
	} else {
		
		alert(error);
		
	}
		
	return false;
});

function load(val) {
	
	$.post('ajax.php', { val:val, action:'load' }, function(data) {
		
		$('#'+val+'-tab .data').empty().append(data);
		$('.add .field:first-child input').focus();
		
	});
	
}

function suppr(val, id) {
	
	$.post('ajax.php', { val:val, id:id, action:'suppr' }, function(data) {
		
		load(val);
		
	});
	
}

function edit(val, id) {
	
	var code = $('#'+val+'-'+id+' input[name=edit-'+val+'-code]').val();
	var code_interne = '';
	if( val == 'gestion-materiel' ) { code_interne = $('#'+val+'-'+id+' input[name=edit-'+val+'-code-interne]').val(); }
	var nom = $('#'+val+'-'+id+' input[name=edit-'+val+'-nom]').val();

	$.post('ajax.php', { code:code, code_interne:code_interne, nom:nom, val:val, id:id, action:'edit' }, function(data) {
		
		load(val);
		alert('Modification réussie');
		
	});
	
}

$('#scan-form input').keydown(function (e) {
	
	var name = $(this).attr('name');
	var type_validation = sessionStorage.getItem('type_validation');

	if(e.keyCode == 13) {
	    
	    if( name == 'code_materiel' ) {
		    $('input[name=code_personne]').focus();
			return false;
	    }
	    else if( name == 'code_personne' ) {
		    
			if( type_validation == 0 || type_validation == 2 ) {
				$('#scan-form input[name=code_validation]').focus();
			} else {
				$('#scan-form input[type=submit]').focus();
			}
			return false;
	    }
	    else if( name == 'code_validation' ) {
			
			$('#scan-form').submit();
			return false;
		
	    }
	
	}
    
});

function export_datas() {
	
	var entrees_sorties_data = $('#entrees-sorties-tab .data').html();
	var materiel_data = $('#statut-materiel-tab .data').html();
	$.post('ajax.php', { entrees_sorties_data:entrees_sorties_data, materiel_data:materiel_data, action:'export' }, function() {
		
		alert('Données exportées');
		load('exports');
		
	});
	
}

function check_login() {
	
	if( sessionStorage.getItem('logged') == 0 ) {
		
		$.post('ajax.php', { login_key:login_key, action:'check_login' }, function(data) {
			
			if( data != '' ) {
				
				sessionStorage.setItem('logged','1');
				
			} else {
				
				sessionStorage.setItem('logged','0');
				
			}
			
		});
		
	}
	
}

function logout() {
	
	$.post('ajax.php', { action:'logout' }, function(data) {
		
		window.location.href = '';
		
	});
	
}

function load_code_validation() {
	
	$.post('ajax.php', { action:'load_code_validation' }, function(data) {
		
		sessionStorage.setItem('code_validation',data);
		$('#validation-form input[name=code_validation]').val(data);
		
	});
	
}

function load_type_validation() {
	
	$.post('ajax.php', { action:'load_type_validation' }, function(data) {
		
		sessionStorage.setItem('type_validation',data);
		$('#validation-form select[name=type_validation]').val(data);
		
		if( data == 0 ) {
			$('#scan-form input[type=submit]').hide();
		}
		if( data == 1 ) {
			$('#scan-form input[name=code_validation]').remove();			
		}
		
		$('#scan-form .encart').hide();
		$('#scan-form .encart-'+data).show();
		
		
	});
	
}