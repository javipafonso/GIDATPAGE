<?
include("./include/session.php");
$item = $cliente->editarCitaAgenda(); 
include("include/metas.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	
<script type="text/javascript">
	// function generar_calendario(mes,anio)
	// {
	// 	var agenda=$(".cal");
	// 	agenda.html("<img src='img/loading.gif'>");
	// 	$.ajax({
	// 		type: "GET",
	// 		url: "agdcalendario.php",
	// 		cache: false,
	// 		data: { mes:mes,anio:anio,accion:"generar_calendario" }
	// 	}).done(function( respuesta ) 
	// 	{
	// 		agenda.html(respuesta);
	// 	});
	// }
	/*function eliminarAlta(){

		document.getElementById("modcita").name = 'eliminarCita';
		j('#formNuevo').attr("action" , "_ajax.php?tipo=nuevaCitaAgenda") ;											
		j('#formNuevo').attr("target" , "Fenviosegc") ; 		
		j('#formNuevo').submit() ;
	}*/
	//Método para eliminar cita
	


	function eliminarCita()
	{
		document.getElementById("modcita").value = 0;
		var eli =  j('input[name^="eliminarCita"]').val();
		var f =  j('input[name^="fechaid"]').val();				
		//alert(f);
		Dcli.loading();
		 j.ajax({
		 type: "GET", 
		 url: "_ajax.php",
		 data:"tipo=eliminarCita" + "&eliminarCita=" + eli + "&fechaid=" + f,
		 dataType: "json",
		 success: function(a) {		 	
		 	//alert(a.resultado);
	  		if (a.resultado){
	  			Dcli.alerta("<?=$cliente->dic_textos['cita_eliminada']?>" , function(){
															//document.location = "inicio.php" ;
																location.reload("#calendario_agenda");					
																
															
														})
	  			Dcli.loading('hide');
	  			close();
	  			
	  		}
	  	}
	  	})

		// j('#formNuevo').attr("action" , "_ajax.php?tipo=nuevaCitaAgenda") ;															
		// j('#formNuevo').submit() ;
		
	  			
	  			//ocation.reload("#calendario_agenda");
	}
	
	//Método para validar los campos que se tienen que rellenar y enviar al método que está en cliente.
	function validarAlta(){

			var add =  j('input[name^="addCita"]').val();			
			if (add != 1)
				var mod =  j('input[name^="modificarCita"]').val();											
			var error = false ; 
			var el ; 
			var indice;
			el = j('textarea[name^="agdcomentario"]') ; 
			Dcli.desEnFoca(el);													
			if( j.trim( el.val() ) == null || j.trim( el.val() ).length == 0 || /^\s+$/.test(j.trim( el.val() )) ) {
			//if( j.trim( el.val() ) == "" ){
				error = true 
				Dcli.enFoca(j(el));
			}
			if( error )
					return ;
			el = j('input[name^="agdcontacto"]') ; 
			Dcli.desEnFoca(el);													//^\s+$
			if( j.trim( el.val() ) == null || j.trim( el.val() ).length == 0 || (/[.?{|}()#]¿/.test(j.trim( el.val() ))) ) {
			//if( j.trim( el.val() ) == "" ){
				error = true 
				Dcli.enFoca(j(el));
			}
			if( error )
					return ;
			el = j('input[name^="agdhora"]') ; 
			var h = el.val().split(':');
			Dcli.desEnFoca(el);
			if(  j.trim( el.val() ) == null || j.trim( el.val() ).length == 0 || !(/^\d{2}:\d{2}$/).test( j.trim( el.val() )) || (!(parseInt(h[0]) < 25 && (parseInt(h[0]) > -1))) || (!(parseInt(h[1]) < 61 && (parseInt(h[1]) > -1)))){
				error = true 
				Dcli.enFoca(j(el));
			}
			
			if( error )
					return ;
			el = j('input[name^="agdtelefono"]') ; 
			Dcli.desEnFoca(el);			
			if( j.trim(el.val()) == ""  ||  j.trim( el.val() ) == null || j.trim( el.val() ).length > 30 ){
				error = true 
				Dcli.enFoca(j(el));
			}
			
			if( error )
					return ;
			if (add != 1){
				el = j('input[name^="agdfecha"]') ;
				var s = el.val().split('/'); 
				var date = new Date();				
				Dcli.desEnFoca(el);			
				if(( j.trim( el.val() ) > 0 ) || (!(/^\d{1,2}[\/]\d{2}[\/]\d{4}$/).test( j.trim( el.val() )) ) || (!(parseInt(s[0]) < 32 && (parseInt(s[0]) > 0))) || (!(parseInt(s[1]) < 13 && (parseInt(s[1]) > 0))) || (!(parseInt(s[2]) >= date.getFullYear()))) {
					error = true 
					Dcli.enFoca(j(el));
				}
			}
			if( error )
					return ;
		var com = j('textarea[name^="agdcomentario"]').val(); 
		var con = j('input[name^="agdcontacto"]').val(); 
		var hora = j('input[name^="agdhora"]').val(); 
		var tlf = j('input[name^="agdtelefono"]').val();		
		var d = "";		
		if (document.getElementById('agddestacado').checked)	
			d = 'S';
		else
			d = 'N';
		if (add != 1){
			var h= "";
			var f = j('input[name^="fechaid"]').val();
			var fecha = j('input[name^="agdfecha"]').val(); 
			if (document.getElementById('agdhecho').checked)	
				h = 'S';
			else
				h = 'N';
		}
		//var agenda = $("#dialog-new-cita");
		//agenda.html("<img src='img/loading.gif'>");
		if (add != 1){
			var  cpre = j('input[name^="codpresupuesto"]').val();				
			var  cped = j('input[name^="codpedido"]').val();
			
			 //Dcli.loading();
			 j.ajax({
			 type: "GET", 
			 url: "_ajax.php",
			 data:"tipo=nuevaCitaAgenda" + "&codpedido=" + cped + "&codpresupuesto=" + cpre + "&agdfecha=" + fecha  + "&agdcomentario=" + com + "&agdcontacto=" + con + "&agdhora=" + hora + "&agdtelefono=" + tlf + "&modificarCita=" + mod + "&fechaid="+ f + "&agdhecho=" + h + "&destacado=" + d,
			 dataType: "json",
			 success: function(a) {				  		
			 	
		  		if (a.resultado){
		  			Dcli.alerta("<?=$cliente->dic_textos['cita_guardada_correctamente']?>" , function(){
																//document.location = "inicio.php" ;
																	location.reload("#calendario_agenda");					
																	
																
															})
		  			Dcli.loading('hide');
		  			close();
		  			
		  		}
		  		else{
		  			Dcli.alerta("<?=$cliente->dic_textos['guardar_ko']?>" , function(){
																//document.location = "inicio.php" ;
																	location.reload("#calendario_agenda");					
																	
																
															})
		  			Dcli.loading('hide');
		  			close();
		  		}
		  	}
		  	})
		}
		else{
			var f =  j('#fecha').val();	
			var	altaAgenda = j('#altaAgenda').val();
			var usuario = "<?php echo $cliente->usuario->UsrATSA; ?>" ;	
			var crazon="";		
			if (usuario == 'S'){
				var  ccliente = j('#codcliente').val();			
				var  cpre = j('#codpresupuesto').val();
				if (cpre == "")
					cpre = document.getElementById("codpedido").value;			
				var  cped = $('#codpedido option:selected').text();	
				if	(document.getElementById("clientenoregistrado").value != "")
						crazon = j('#clientenoregistrado').val();		
			}

			if (usuario == 'N'){
				var  ccliente = "";			
				var  cpre = "";				
				var  cped = "";		
				if	(document.getElementById("clientenoregistrado2").value != "")
						crazon = j('#clientenoregistrado2').val();				
								
			}	

			
				

			Dcli.loading();

			 j.ajax({
			 type: "GET", 
			 url: "_ajax.php",			
			 data:"tipo=nuevaCitaAgenda" + "&codpedido=" + cped + "&codpresupuesto=" + cpre + "&clienterazon=" + crazon + "&codcliente=" + ccliente + "&altaAgenda=" + altaAgenda + "&agdcomentario=" + com + "&agdcontacto=" + con + "&agdhora=" + hora + "&agdtelefono=" + tlf + "&fecha="+ f + "&destacado=" + d,
			 dataType: "json",
			 success: function(a) {				  		
			 	//alert(a.resultado);
		  		if (a.resultado){
		  			Dcli.alerta("<?=$cliente->dic_textos['cita_guardada_correctamente']?>" , function(){
																//document.location = "inicio.php" ;
																	location.reload("#calendario_agenda");					
																	
																
															})
		  			Dcli.loading('hide');
		  			close();
		  			
		  		}
		  		else{
		  			Dcli.alerta("<?=$cliente->dic_textos['guardar_ko']?>" , function(){
																//document.location = "inicio.php" ;
																	location.reload("#calendario_agenda");					
																	
																
															})
		  			Dcli.loading('hide');
		  			close();
		  		}
		  	}
		  	})
		}
		//j('#formNuevo').attr("action" , "_ajax.php?tipo=nuevaCitaAgenda") ;	
		//j('#formNuevo').submit() ;
				
	}
	
	

	function formatDate (input) {
		var datePart = input.match(/\d+/g),	year = datePart[0],	month = datePart[1], day = datePart[2];
		/*var idioma = <?=$cliente->idioma?>;
		if (idioma == 2)			
			return month+'-'+day+'-'+year;
		else*/
			return day+'/'+month+'/'+year;
	}
	function close(){
		j('#mask').fadeOut();
				setTimeout(function() 
				{ 
					var fecha=$(".window").attr("rel");
					var fechacal=fecha.split("-");
					
				}, 200);
				
	}

	
	//Añadir por Javier Pérez Afonso para mostrar un evento
	//function modificar_cita(fechas,comentarios,telefonos,destacados,hechos,contactos){
	function modificar_cita(obj){

		
		
					
		var html="";
					
		var hora="";
		var contacto="";
		var comentario="";
		var telefono="";
		var destacado="";
		var hecho = "";
		var codppto = "";
		var codped = "";
		var table = document.getElementById("tablaVerSeguimiento");
		var fila = parseInt(obj.id) + 1;		

		for (var i = fila, row; row = table.rows[i]; i++) {
			
		    	 
		   		 hora = row.cells[0].innerHTML.substring(0,6);
		   		 comentario = row.cells[1].innerHTML;
		   		  contacto = row.cells[2].innerHTML;
		   		  destacado = row.cells[3].innerHTML;
		   		  telefono = row.cells[7].innerHTML;
		   		  codppto = row.cells[5].innerHTML;
		   		  codped = row.cells[6].innerHTML;
		   		 hecho = row.cells[4].innerHTML;
		   	 	  
		     
		}
		
		if (String(codppto) != "00000000")
			html2 = "<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['presupuestos']?>:</div><input  type=\"text\"  name=\"codpresupuesto\" value='" + codppto + "' class=\"required\" maxlength=\"50\"/>";
		else
			html2 = "<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['presupuestos']?>:</div><input  type=\"text\"  name=\"codpresupuesto\"  class=\"required\" maxlength=\"50\"/>";

		if (codped != "0")
			html3 = "<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['pedidos']?>:</div><input type=\"text\" name=\"codpedido\"   value='" + codped + "' class=\"required\" maxlength=\"50\"/>";	
		else
			html3 = "<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['pedidos']?>:</div><input type=\"text\" name=\"codpedido\"   class=\"required\" maxlength=\"50\"/>";	
		if (destacado == 'S')		
			html="<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['destacado']?>: <input type=\"checkbox\" id='agddestacado' name=\"agddestacado\" class=\"required\" checked/></div>";					
		else
			html="<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['destacado']?>: <input type=\"checkbox\" id='agddestacado' name=\"agddestacado\" class=\"required\" /></div>";						
		if (hecho == 'S')		
			html1="<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['hecho']?>: <input type=\"checkbox\" id='agdhecho' name=\"agdhecho\" class=\"required\" checked/></div>";
		else
			html1="<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['hecho']?>: <input type=\"checkbox\" id='agdhecho' name=\"agdhecho\" class=\"required\" /></div>";
		$('#mask').fadeIn(200).html("<div id='dialog-new-cita' method='post' class='window' rel=''><?=$cliente->dic_textos['modificar_cita']?>:</h2>" +
			"<a href='javascript:close()' class='close' rel='/*+fecha+*/'>&nbsp;</a><div id='respuesta_form'></div><form class='formeventos' id='formNuevo' method='post' >" +	
			"<table data-column=\"5\" width=\"80%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">" +
			"<tr>" +
				"<td >" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['fecha']?>: </div>" +
					"<input type='text' name='agdfecha' id='contacto' class='required' value='" + formatDate($('#' + obj.id).attr('title'))+ "'/>" +
					"<input type=\"hidden\" name=\"fechaid\" value='" + $('#' + obj.id).attr('title') + "'/>" +			
				"</td>" +
				"<td >" +					
					"<div style=\"margin-bottom:.5em;\">Hora: </div>" +
					"<input type='text' name='agdhora' id='hora' class='required' value='" + hora + "'/>" +			
				"</td>" +
			"</tr>" +			
			"<tr>" +
				"<td colspan='5'>&nbsp</td>" +
			"</tr>" +
			"<tr>" +
				"<td colspan='2'>" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['comentario']?>: (<?=$cliente->dic_textos['max_250']?>)</div>" +
					"<textarea name=\"agdcomentario\" class=\"required\" >" + comentario + "</textarea>" +			
				"</td>" +
			"</tr>" +			
			"<tr>" +
				"<td colspan='5'>&nbsp</td>" +
			"</tr>" +
			"<tr>" +
				"<td >" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['contacto']?>:</div>" +
					"<input type=\"text\" name=\"agdcontacto\" id='contacto' value='" + contacto + "' class=\"required\" maxlength=\"50\"/>" +
				"</td>" +			
				"<td>" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['telefono']?>:</div>" +
					"<input type=\"text\" name=\"agdtelefono\"  value='" + telefono + "' class=\"required\" maxlength=\"50\"/>" +
				"</td>" +
			"</tr>" +
			"<tr>" +
				"<td colspan='5'>&nbsp</td>" +
			"</tr>" +
			"<tr id='pedrows'>" +
				"<td >" +
					html2 +
				"</td>" +			
				"<td>" +
					html3 +
				"</td>" +
			"</tr>" +
			"<tr>" +
				"<td colspan='5'>&nbsp</td>" +
			"</tr>" +
			"<tr>" +
				"<td >" +
					html +
				"</td>" +
				"<td >" +					
					 html1 +
				"</td>" +
			"</tr>" +
			"<tr>" +
				"<td colspan='5'>&nbsp</td>" +
			"</tr>" +
			
			"</table>" +
			"<table align='right'>" +
			"<tr>" +
				"<td >" +					
					"<div align='right'><input type=\"hidden\" id='modcita' name=\"modificarCita\" value=\"1\"/><a id='btn' class='btn' href='javascript:validarAlta()' target='' alt=''><?=$cliente->dic_textos['modificar']?></a><div>" +					
				"</td>" +
				 "<td >" +
				 	"<div align='right'><input type=\"hidden\" id='modcita' name=\"eliminarCita\" value=\"1\"/><a id='btn' class='btn' href='javascript:eliminarCita()' target='' rel='1'><?=$cliente->dic_textos['borrar']?></a><div>" +
					 
				 "</td>" +
			"</tr>" +	
			"</table>" +																			
			"</form></div>");
		
	}
	
	//Añadir por Javier Pérez Afonso para mostrar un evento
	function mostrar_cita(obj)
	//function mostrar_cita(fechas,comentarios,telefonos,destacados,hechos,contactos)
	{	

			
			
			var s = $("#"+obj.id).attr('rel');	//fecha seleccionada
			var usuario = "<?php echo $cliente->usuario->UsrLogin; ?>";		

			var html = "";
			
			j.ajax({
		type: "GET", 
		url: "_ajax.php",
		data:"tipo=obtenerAgendaDia" + "&cliente=" + usuario + "&fecha=" + s,
		dataType: "json",
		success: function(a) {			
			   
				var sty="font-weight: normal";
				var clase = "tr-alt" ;	
				html+= "<table id=\"tablaVerSeguimiento\" class=\"tableLineas tablesorter\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">" +
				"<thead>" +
					"<tr>" + 
						"<th><?=$cliente->dic_textos['hora']?></th>" +
						"<th ><?=$cliente->dic_textos['comentario']?></th>" +
						"<th ><?=$cliente->dic_textos['contacto']?></th>"	+ 
						"<th ><?=$cliente->dic_textos['hecho']?></th>"	+ 					
					"</tr>" +
				"</thead>"+
				"<tbody>"; 				
				for (var i = 0; i < a.citasagenda.length;i++){									
					var clase = "tr-alt" ;	


					if (a.citasagenda[i].AgdDestacado == 'S'){
						var sty="font-weight: bold";	
						
					}
					
					html+= "<tr id='" + i + "' class='" + clase + "' onClick=\"modificar_cita(this)\" title='" + a.citasagenda[i].AgdFecha + "'>";
					 html+= "<td style='" + sty + ";width:30px;' id='agdhoras' >" + a.citasagenda[i].AgdFecha.substring(10) + "</td>";
					 html+= "<td style='" + sty + ";' id='agdcoment'>" + a.citasagenda[i].AgdComentario + "</td>";
					 html+= "<td style='" + sty + ";width:100px;' id='agdcontact' >" + a.citasagenda[i].AgdContacto + "</td>";
					 html+= "<td style='" + sty + ";width:100px;display:none;' id='agdestacado' >" + a.citasagenda[i].AgdDestacado + "</td>";
					  html+= "<td style='" + sty + ";' id='agdestacado' >" + a.citasagenda[i].AgdHecho + "</td>";					 					 					 
					  	html+= "<td style='display:none;' id='agdppto' >" + a.citasagenda[i].AgdCodPpto + "</td>";					 
					  	html+= "<td  style='display:none;' id='agdped' >" + a.citasagenda[i].AgdCodPed + "</td>";
					 html+= "<td style='display:none;' id='agdtelef'>" + a.citasagenda[i].AgdTelefono + "'</td></tr></a>";
					
				}
				html+="</tbody>";
				html+="<table>"; 			
				document.getElementById("tablaVerSeguimiento").outerHTML = html;
				
			}
		
		
		})
			$('#mask').fadeIn(200).html("<div id='nuevo_evento' class='window' rel='"+s+"'><h2><?=$cliente->dic_textos['agenda_del']?> "+formatDate(s)+"</h2><a href='javascript:close()' class='close' rel='"+s+"'>&nbsp;</a><div id='respuesta'></div><table id=\"tablaVerSeguimiento\" class=\"tableLineas tablesorter\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><table></div>");
				
	}
	
	function myFunction()
	{
		var x = document.getElementById("codpresupuesto").value;
		if (x !== "")			
			$('#codpedido').attr('disabled', true);
			//document.getElementById("codpedido").disabled = 'disabled';
		else
			$('#codpedido').attr('disabled', false);
			
					//document.getElementById("codpedido").disabled = 'false';
	}
	function myFunction2()
	{
		var x = document.getElementById("codpedido").value;
		if (x !== ""){
			
			$('#codpresupuesto').attr('disabled', true);
		}else
			$('#codpresupuesto').attr('disabled', false);
	}

	function select_ped(){

		var html2 = "<select id='codpedido' name='codpedido' style=\"margin-bottom:.5em;\" onChange=\"myFunction2()\" ><option  value=''></option>";
		var x = document.getElementById("codcliente").value;
		//Dcli.loading( 'show' );
		j.ajax({
		type: "GET", 
		url: "_ajax.php",
		data:"tipo=obtenerPed" + "&cliente=" + x,
		dataType: "json",
		success: function(a) {			
			for (var i = 0; i < a.codpedidos.length;i++){				
				html2 += "<option value='" + a.codpedidos[i].AecCodPpto + "'>" + a.codpedidos[i].AecCodPed + "</option>";
				
			}
			
			html2 += "</select>";
			document.getElementById("codpedido").outerHTML = html2;
		}
		})

	} 
	
	function select_pre(){

		var html = "<select id='codpresupuesto' name='codpresupuesto' onChange=\"myFunction()\" style=\"margin-bottom:.5em;\" ><option  value=''></option>";
		var x = document.getElementById("codcliente").value;
		//Dcli.loading( 'show' );
		j.ajax({
		type: "GET", 
		url: "_ajax.php",
		data:"tipo=obtenerPresu" + "&cliente=" + x,
		dataType: "json",
		success: function(a) {
			for (var i = 0; i < a.resultado.length;i++){				
				html += "<option value='" + a.resultado[i].PpeCodPpto + "'>" + a.resultado[i].PpeCodPpto + "</option>";
			}
			
			html += "</select>";	
			document.getElementById("codpresupuesto").outerHTML = html;
		}
		})

	} 
	function select_data_cliente(){

		var x = document.getElementById("razon").value;		
		//Dcli.loading( 'show' );
		j.ajax({
		type: "GET", 
		url: "_ajax.php",
		data:"tipo=obtenerDatos" + "&razon=" + x,
		dataType: "json",
		success: function(a) {							
			$('input[name="agdtelefono"]').val(a.datos[0].CliTelefono) ;
      		$('input[name="codcliente"]').val(a.datos[0].CliCodCli) ;
      		$('input[name="agdcontacto"]').val(a.datos[0].CliContacto) ;
      		$('#codcliente').attr('disabled', true);	
      		 select_pre();
      		 select_ped();
		}
		})
		

	} 
	function selectoptions()
	{
		
		var x = document.getElementById("razon").value;
		if (x === ""){
      		$('input[name="clientetelefono"]').val("") ;
      		$('input[name="codcliente"]').val("") ;
      		$('input[name="clientecontacto"]').val("") ;      		
      		select_pre();
      		select_ped();
      	}
		
      	select_data_cliente();
      		
      		
     
 		

	}
	
	function cliente_no_reg()
	{
		var x = document.getElementById("clientenreg").checked;
		var usuario = "<?php echo $cliente->usuario->UsrATSA; ?>" ;
		if (x){			
			
			if (usuario == 'S'){
				
				document.getElementById("clientenoregistrado").style.display = "block";	
				document.getElementById("razon").style.display = "none";
				$('#codpedido').attr('disabled', true);
				$('#codpresupuesto').attr('disabled', true);
				$('#codcliente').attr('disabled', true);
				document.getElementById("codcliente").value = "";							
			}
			else{
				document.getElementById("clientenoregistrado2").style.display = "block";
				document.getElementById("divrazon2").style.display = "block";	
			}

		}else{
			
			
			if (usuario == 'S'){
				document.getElementById("clientenoregistrado").style.display = "none";	
				document.getElementById("razon").style.display = "block";
				$('#codpresupuesto').attr('disabled', false);
				$('#codpedido').attr('disabled', false);
				$('#codcliente').attr('disabled', false);
			}
			else{
				document.getElementById("clientenoregistrado2").style.display = "none";
			document.getElementById("divrazon2").style.display = "none";			
			}
		}
	}

	//Añadido por Javier Pérez Afonso para añadir una cita en la agenda
	//function anadir_cita(ped,presu,clientes,fecha,usuario){
	function anadir_cita(obj){		


		
		var html2="<select id='razon' name='clienterazon' style=\"margin-bottom:.5em;\" onChange=\"selectoptions()\"><option  value=''></option>";		
		j.ajax({
		type: "GET", 
		url: "_ajax.php",
		data:"tipo=obtenerCliente",
		dataType: "json",
		success: function(a) {	
			
			for (var i = 0; i < a.clientes.length;i++){		
				 
				html2 += "<option value='" + a.clientes[i].CliRazon + "'>" + a.clientes[i].CliRazon + "</option>";
			}
			html2 += "</select>";	
			document.getElementById("razon").outerHTML = html2;
			document.getElementById("clientenoregistrado").style.display = "none";

		},
		})

		var d = new Date();
		var s = $("#"+obj.id).attr('rel');
		var result = "" + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();			
		var html="";
		var usuario = "<?php echo $cliente->usuario->UsrATSA; ?>" ;
		
		if ( usuario == 'S')
		{	
			
			html+="<tr>" +
				"<td  colspan='2'>" +
					"<div style=\"margin-bottom:.8em;\"><?=$cliente->dic_textos['razon']?>:</div>" +
					"<select id='razon' name='clienterazon' style=\"margin-bottom:.5em;\" onChange=\"selectoptions()\">" +
						"<option value=''></option>" +
					"</select>" +
					"<input type=\"text\" name=\"clienterazon\" style='display:none;' id='clientenoregistrado' class=\"required\" />" +
										
				"</td>" +
				"<td >" +
					"<div style=\"margin-bottom:.65em;\"><?=$cliente->dic_textos['codigo_cliente']?>:</div>" +
					"<input type=\"text\" name=\"codcliente\" id='codcliente' class=\"required\" maxlength=\"50\"/>" +
				"</td>" +
			"</tr>" +			
			"<tr>" +
				"<td >&nbsp</td>" +
			"</tr>" +			
			"<td  colspan='2'>" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['presupuestos']?>:</div>" +
					"<select  id='codpresupuesto' name='codpresupuesto' style=\"margin-bottom:.5em;\" onChange=\"myFunction()\">" +	
					"</select>" +
				"</td>" +
				"<td  >" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['pedidos']?>:</div>" +
					"<select id='codpedido' name='codpedido' style=\"margin-bottom:.5em;\" onChange=\"myFunction2()\">" +
					"</select>" +
				"</td>" +
			"</tr>";
			
		}
		
		$('#mask').fadeIn(200).html("<div id='dialog-new-cita' method='post' class='window' rel='"+s+"'><?=$cliente->dic_textos['agregar_cita']?> "+formatDate(s)+":</h2>" +
			"<a href='javascript:close()' class='close' rel='"+s+"'>&nbsp;</a><div id='respuesta_form'></div><form class='formeventos' id='formNuevo' method='post' >" +	
			"<table  width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">" +
			"<tr>" +
				"<td colspan='2'>" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['contacto']?>: </div>" +
					"<input type='text'  name='agdcontacto' id='contacto' class='required'/>" +						
					"<input type=\"hidden\" id='altaAgenda' name=\"altaAgenda\" value=\"1\">" +			
				"</td>" +
				"<td >" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['hora']?>: </div>" +
					"<input type='text' name='agdhora' id='hora' class='required' />[HH:MM]" +			
				"</td>" +
			"</tr>" +			
			"<tr>" +
				"<td >&nbsp</td>" +
			"</tr>" +
			"<tr>" +
				"<td colspan='3'>" +
					"<div style=\"margin-bottom:.5em;\"><?=$cliente->dic_textos['comentario']?>: (<?=$cliente->dic_textos['max_250']?>)</div>" +
					"<textarea   name=\"agdcomentario\" class=\"required\" ></textarea>" +			
				"</td>" +
			"</tr>" +			
			"<tr>" +
				"<td >&nbsp</td>" +
			"</tr>" +
			"</table>" +
			"<input type=\"hidden\" id='fecha' name=\"fecha\" value=" + s + ">" +															
			"<div align='right'><input type=\"hidden\" id='modcita' name=\"addCita\" value=\"1\"/><a id='btn-new-cita' class='btn' href='javascript:validarAlta()' target='' alt='' rel='add'><?=$cliente->dic_textos['guardar']?></a><div></form></div>");
	}
	
	/*	$(document).ready(function()
		{
			 GENERAMOS CALENDARIO CON FECHA DE HOY 
			generar_calendario("","");
			
			
			 AGREGAR UN EVENTO 
			$(document).on("click",'a.add',function(e) 
			{
				
				e.preventDefault();
				var id = $(this).data('evento');

				var fecha = $(this).attr('rel');
				
				$('#mask').fadeIn(1000).html("<div id='nuevo_evento' class='window' rel='"+fecha+"'>Agregar un evento el "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a><div id='respuesta_form'></div><form class='formeventos'><input type='text' name='evento_titulo' id='evento_titulo' class='required'><input type='button' name='Enviar' value='Guardar' class='enviar'><input type='hidden' name='evento_fecha' id='evento_fecha' value='"+fecha+"'></form></div>");
			});
			
			 LISTAR EVENTOS DEL DIA 
			$(document).on("click",'a.modal',function(e) 
			{
				e.preventDefault();
				var fecha = $(this).attr('rel');
				
				$('#mask').fadeIn(1000).html("<div id='nuevo_evento' class='window' rel='"+fecha+"'>Eventos del "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a><div id='respuesta'></div><div id='respuesta_form'></div></div>");
				$.ajax({
					type: "GET",
					url: "ajax_calendario.php",
					cache: false,
					data: { fecha:fecha,accion:"listar_evento" }
				}).done(function( respuesta ) 
				{
					$("#respuesta_form").html(respuesta);
				});
			
			});
		
			$(document).on("click",'.close',function (e) 
			{
				e.preventDefault();
				$('#mask').fadeOut();
				setTimeout(function() 
				{ 
					var fecha=$(".window").attr("rel");
					var fechacal=fecha.split("-");
					generar_calendario(fechacal[1],fechacal[0]);
				}, 500);
			});
		
			//guardar evento
			$(document).on("click",'.enviar',function (e) 
			{
				e.preventDefault();
				if ($("#evento_titulo").valid()==true)
				{
					$("#respuesta_form").html("<img src='images/loading.gif'>");
					var evento=$("#evento_titulo").val();
					var fecha=$("#evento_fecha").val();
					$.ajax({
						type: "GET",
						url: "ajax_calendario.php",
						cache: false,
						data: { evento:evento,fecha:fecha,accion:"guardar_evento" }
					}).done(function( respuesta2 ) 
					{
						$("#respuesta_form").html(respuesta2);
						$(".formeventos,.close").hide();
						setTimeout(function() 
						{ 
							$('#mask').fadeOut('fast');
							var fechacal=fecha.split("-");
							generar_calendario(fechacal[1],fechacal[0]);
						}, 3000);
					});
				}
			});
				
			//eliminar evento
			$(document).on("click",'.eliminar_evento',function (e) 
			{
				e.preventDefault();
				var current_p=$(this);
				$("#respuesta").html("<img src='images/loading.gif'>");
				var id=$(this).attr("rel");
				$.ajax({
					type: "GET",
					url: "ajax_calendario.php",
					cache: false,
					data: { id:id,accion:"borrar_evento" }
				}).done(function( respuesta2 ) 
				{
					$("#respuesta").html(respuesta2);
					current_p.parent("p").fadeOut();
				});
			});
				
			$(document).on("click",".anterior,.siguiente",function(e)
			{
				e.preventDefault();
				var datos=$(this).attr("rel");
				var nueva_fecha=datos.split("-");
				generar_calendario(nueva_fecha[1],nueva_fecha[0]);
			});

		});*/
		
		
</script>
		
</head>
	
	
<body>
	<div class="calendario_ajax">
		<?php
			//include("config.inc.php");
			$mostrar="";
			function fecha ($valor)
			{
				$timer = explode(" ",$valor);
				$fecha = explode("-",$timer[0]);
				$fechex = $fecha[2]."/".$fecha[1]."/".$fecha[0];
				return $fechex;
			}
			if (isset($_POST["guardarevento"])=="Si")
			{

				/*$agenda = new TCitaAgenda();
				foreach( $agenda as $item ){
					echo "<script type=\"text/javascript\">alert('.$item->AgdFecha.')</script>";
				}*/
				//$q1="insert into tcalendario (fecha,evento) values ('".$_POST["fecha"]."','".strip_tags($_POST["titulo"])."')";
				//mysql_select_db($dbname);
				//if ($r1=mysql_query($q1)) $mostrar="<p class='ok' id='mensaje'>Evento guardado correctamente.</p>";
				//else $mostrar= "<p class='error' id='mensaje'>Se ha producido un error guardando el evento.</p>";
			}
			if (isset($_GET["borrarevento"]))
			{
				//$q1="delete from tcalendario where id='".$_GET["borrarevento"]."' limit 1";
				//mysql_select_db($dbname);
				//if ($r1=mysql_query($q1)) $mostrar="<p class='ok' id='mensaje'>Evento eliminado correctamente.</p>";
				//else $mostrar="<p class='error' id='mensaje'>Se ha producido un error eliminando el evento.</p>";
			}
			
			if (isset($_POST["addevent"])=="Si")
			{	
				
				//$q1="insert into tcalendario (fecha,evento) values ('".$_POST["fechas"]."','".$_POST["titulos"]."')";
				//mysql_select_db($dbname);
				//if ($r1=mysql_query($q1)) $mostrar="<p class='ok' id='mensaje'>Evento guardado correctamente.</p>";
				//else $mostrar="<p class='error' id='mensaje'>Se ha producido un error guardando el evento.</p>";
			}
			
			if (!isset($_GET["fecha"])) 
			{
				$mesactual=intval(date("m"));
				if ($mesactual<10) $elmes="0".$mesactual;
				else $elmes=$mesactual;
				$elanio=date("Y");
			} 
			else 
			{
				$cortefecha=explode("-",$_GET["fecha"]);
				$mesactual=intval($cortefecha[1]);
				if ($mesactual<10) $elmes="0".$mesactual;
				else $elmes=$mesactual;
				$elanio=$cortefecha[0];
			}
			
			$primeromes=date("N",mktime(0,0,0,$mesactual,1,$elanio));
			
			if (!isset($_GET["mes"])) $hoy=date("Y-m-d"); 
			else $hoy=$_GET["ano"]."-".$_GET["mes"]."-01";
			
			if (($elanio % 4 == 0) && (($elanio % 100 != 0) || ($elanio % 400 == 0))) $dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
			else $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31");
			
			$ides=array();
			$eventos=array();
			$titulos=array();
			$destacado=array();
			$telefono=array();
			$contacto=array();
			$hecho=array();
			$c=array();


			$meses=array("",$cliente->dic_textos['enero'],$cliente->dic_textos['febrero'],$cliente->dic_textos['marzo'],$cliente->dic_textos['abril'],$cliente->dic_textos['mayo'],$cliente->dic_textos['junio'],$cliente->dic_textos['julio'],$cliente->dic_textos['agosto'],$cliente->dic_textos['septiembre'],$cliente->dic_textos['octubre'],$cliente->dic_textos['noviembre'],$cliente->dic_textos['diciembre']);
			
			/*$presu = $item->getPpto();
			$h = 0;
			$j = 0;	
			
			while (count($presu) > $j){
				$c[$h] = $presu[$j]["PpeCodPpto"];
			 	$h+=1;
			 	$c[$h] = $presu[$j]["PpeCodCli"];
			 	$h+=1;
			 	$j+=1;
			}				
			$presuf = implode(',', $c);*/

			//Se ha hecho para los pedidos.
			/*$ped = $item->getPed();			
			$h = 0;
			$j = 0;
			unset($c);	
			while (count($ped) > $j){
				$c[$h] = $ped[$j]["AecCodCli"];
			 	$h+=1;
			 	$c[$h] = $ped[$j]["AecCodPed"];			 	
			 	$h+=1;
			 	$c[$h] = $ped[$j]["AecCodPpto"];
			 	$h+=1;			 	
			 	$j+=1;
			}
			$pedf = implode(',',$c);	*/		
			//$clientesUsr = $item->getClients($cliente->usuario);
			$citag = $item->sacaAgendas($cliente->usuario->UsrLogin,null);			
			$h=0;			
			while (count($citag) > $h ){							
				 $ides[$h]=$citag[$h]["AgdFecha"];
				$eventos[$h]=substr($citag[$h]["AgdFecha"],0,10);																
				/*$titulos[$h]=$citag[$h]["AgdComentario"];
				$destacado[$h]=$citag[$h]["AgdDestacado"];
				$telefono[$h]=$citag[$h]["AgdTelefono"];
				$contacto[$h]=$citag[$h]["AgdContacto"];
				$hecho[$h]=$citag[$h]["AgdHecho"];*/
				$h+=1;
			}
			unset($c);
			$h=0;
			// $j=0;	
			
			//  while (count($clientesUsr) > $j){
			//  	$c[$h] = $clientesUsr[$j]["CliCodCli"];
			//  	$h+=1;
			//  	$pos = strpos($clientesUsr[$j]["CliRazon"], ','); 
			//  	if ($pos === false)
			//  		$c[$h] = $clientesUsr[$j]["CliRazon"];
			//  	else
			//  		$c[$h] = str_replace(',', ' ', $clientesUsr[$j]["CliRazon"]);
			//  	$h+=1;
			//  	$c[$h] = $clientesUsr[$j]["CliTelefono"];			 	
			//  	$h+=1;
			//  	$c[$h] = $clientesUsr[$j]["CliContacto"];
			//  	$h+=1;
			//  	$j+=1;
			//  }
			
			//$clientf = implode(',',$c);			
			//$pedf = implode(',', $ped);									 			
			$fechas = implode(',',$ides);				
			/*$comentarios = implode(',',$titulos);
			$telefonos = implode(',',$telefono);
			$contactos = implode(',',$contacto);
			$hechos = implode(',',$hecho);
			$destacados = implode(',',$destacado);*/
			//$agenda = new TCitaAgenda();
			//	foreach( $item as $s ){
			
			//	}
			//$q1="select * from tcalendario where month(fecha)='".$elmes."' and year(fecha)='".$elanio."'";
			//mysql_select_db($dbname);
			//$r1=mysql_query($q1);
			/*if ($f1=mysql_fetch_array($r1))
			{
				$h=0;
				do
				{
					$ides[$h]=$f1["id"];
					$eventos[$h]=$f1["fecha"];
					$titulos[$h]=$f1["evento"];
					$h+=1;
				}
				while($f1=mysql_fetch_array($r1));
			}*/
			//$usuarioATSA = $cliente->usuario->UsrATSA;			
			$meses=array("",$cliente->dic_textos['enero'],$cliente->dic_textos['febrero'],$cliente->dic_textos['marzo']
				,$cliente->dic_textos['abril'],$cliente->dic_textos['mayo'],$cliente->dic_textos['junio'],$cliente->dic_textos['julio'],$cliente->dic_textos['agosto'],
				$cliente->dic_textos['septiembre'],$cliente->dic_textos['octubre'],$cliente->dic_textos['noviembre'],$cliente->dic_textos['diciembre']);
			$diasantes=$primeromes-1;
			$diasdespues=42;
			$tope=$dias[$mesactual]+$diasantes;
			if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
			else $totalfilas=intval(($tope/7));
			echo "<h2>".$cliente->dic_textos['agenda_para'].": ".$meses[$mesactual]." de ".$elanio."</h2>";
			echo $mostrar;
			echo "<script>function mostrar(cual) {if (document.getElementById(cual).style.display=='block') {document.getElementById(cual).style.display='none';} else {document.getElementById(cual).style.display='block'} }</script>";
			echo "<table id='calendario_agenda' class='calendario' cellspacing='0' cellpadding='0'>";
			echo "<tr><th>".$cliente->dic_textos['lunes']."</th><th>".$cliente->dic_textos['martes']."</th>
			<th>".$cliente->dic_textos['miercoles']."</th><th>".$cliente->dic_textos['jueves']."</th><th>".$cliente->dic_textos['viernes']."</th>
			<th>".$cliente->dic_textos['sabado']."</th><th>".$cliente->dic_textos['domingo']."</th></tr><tr>";
			$j=1;
			$filita=0;
			// function buscarevento($fecha,$eventos,$titulos)
			// {

			// 	$clave=array_search($fecha,$eventos,$titulos);
			// 	return $titulos[$clave];
			// }
			for ($i=1;$i<=$diasdespues;$i++)
			{
				if ($filita<$totalfilas)
				{

				if ($i>=$primeromes && $i<=$tope) 
				{
					echo "<td class=";
					if ($j<10) 
						$dd="0".$j;
					else 
						$dd=$j;					
					$compuesta=$elanio."-$elmes-$dd";
										
					if (count($eventos)>0 && in_array($compuesta,$eventos,true)) 
					{
						$s=array_count_values($eventos);	
						$l = array_search($compuesta, $eventos);
						$x= $s[$compuesta];
						//$comentario = $titulos[$l];						
						echo " \"dias evento\"";						
						$noagregar=true;
					}
					else 
					{	
						if (($hoy==$compuesta)) {
							echo "\"dias hoy\"";
						}				
						else{
							echo " \"dias\"";
							
						}
						$noagregar=false;
					}															
					
					if ($elmes < (substr($hoy,5,2)))
					{	
							if ($elanio > (substr($hoy,0,4))){
								if ($noagregar){														
										echo "'><a id='mod_cita$j' onClick=\"mostrar_cita(this)\" data-evento=\"#evento$j\" class='modal' rel='".$compuesta."' title='".$cliente->dic_textos['hay'].' '.$x.' '.$cliente->dic_textos['citas']."'>$j ($x)</a><a id='add_cita$j' onClick=\"anadir_cita(this)\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>	";
										//echo "'><a id=\"$x\" href=\"javascript:mostrar_cita('$fechas','$comentarios','$telefonos')\" data-evento=\"#evento$j\" class='modal' rel='$compuesta' title='".$cliente->dic_textos['hay']."' $x ".$clientes->dic_textos['citas']."'>$j ($x)</a><a onClick=\"anadir_cita('$compuesta','$usuarioATSA')\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' class='add agregar_evento'><input type=\"hidden\" id='fecha_cita' value='".$compuesta."'/><input type=\"hidden\" id='usuario_ATSA' value='".$usuarioATSA."'/><img src='img/img_calendario/add.png' /></a>	";
									}
									else										
									{											
										if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42 || $i==6 || $i==13 || $i==20 || $i==27 || $i==34 || $i==41)
											echo "'>$j";		
										else
											//echo "'>$j<a href=\"javascript:anadir_cita('$pedf','$presuf',$clientf',$compuesta','$usuarioATSA')\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>";
											echo "'>$j<a id='mod_cita$j' onClick=\"mostrar_cita(this)\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' rel='".$compuesta."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>";
									}
							}
							else{
								if ($noagregar){														
									echo "'><a id='mod_cita$j' onClick=\"mostrar_cita(this)\"  data-evento=\"evento$j\" class='modal' rel='".$compuesta."' title='".$cliente->dic_textos['hay'].' '.$x.' '.$cliente->dic_textos['citas']."'>$j ($x)</a>";
									
								}
								else							
									echo "'>$j";
							}
						//else	
						//	echo "'>$j<a href='javascript:mostrar(\"evento$j\")' title='Crear un Evento el ".fecha($compuesta)."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a><form id='evento$j' method='post' action='".$_SERVER["PHP_SELF"]."' style='display:none'><input type='text' name='titulo' class='text' /><input type='Submit' name='Enviar' value='Guardar' class='enviar' /><input type='hidden' name='guardarevento' value='Si' /><input type='hidden' name='fecha' value='$compuesta' /></form>";										
					}
					if ($elmes >= (substr($hoy,5,2))){
						if ($elmes > (substr($hoy,5,2))){ 
							if ($noagregar){														
										echo "'><a id='mod_cita$j' onClick=\"mostrar_cita(this)\" data-evento=\"#evento$j\" class='modal' rel='".$compuesta."' title='".$cliente->dic_textos['hay']."' '".$x."' '".$cliente->dic_textos['citas']."'>$j ($x)</a>";
										//if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42 || $i==6 || $i==13 || $i==20 || $i==27 || $i==34 || $i==41)
										//	echo "'>$j";
											//echo "<a onClick=\"javascript:anadir_cita()\" rel='".$compuesta."' title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>	"; 																									
									}
									else										
									{											
										if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42 || $i==6 || $i==13 || $i==20 || $i==27 || $i==34 || $i==41)
											echo "'>$j";		
										else
											//echo "'>$j<a href=\"javascript:anadir_cita('$pedf','$presuf',$clientf',$compuesta','$usuarioATSA')\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>";
											echo "'>$j<a id='add_cita$j' onClick=\"anadir_cita(this)\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' rel='".$compuesta."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>";
									}
						}
						if ($elmes == (substr($hoy,5,2))){ 
							if ($j < (substr($hoy , 8,2))){
								if ($noagregar){														
									echo "'><a id='mod_cita$j' onClick=\"mostrar_cita(this)\"  data-evento=\"evento$j\" class='modal' rel='".$compuesta."' title='".$cliente->dic_textos['hay'].' '.$x.' '.$cliente->dic_textos['citas']."'>$j ($x)</a>";
									
								}
								else							
									echo "'>$j";
							}
							else{						
									
									if ($noagregar){
										if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42 || $i==6 || $i==13 || $i==20 || $i==27 || $i==34 || $i==41)
											echo "'><a id='mod_cita$j' onClick=\"mostrar_cita(this)\" data-evento=\"#evento$j\" class='modal' rel='".$compuesta."' title='".$cliente->dic_textos['hay'].' '.$x.' '.$cliente->dic_textos['citas']."'>$j ($x)</a>";														
										else
											echo "'><a id='mod_cita$j' onClick=\"mostrar_cita(this)\" data-evento=\"#evento$j\" class='modal' rel='".$compuesta."' title='".$cliente->dic_textos['hay'].' '.$x.' '.$cliente->dic_textos['citas']."'>$j ($x)</a><a id='add_cita$j' onClick=\"anadir_cita(this)\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."'  rel='".$compuesta."' class='add agregar_evento'><img src='img/img_calendario/add.png'/></a>";
										
									}
									else
									{	
										if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42 || $i==6 || $i==13 || $i==20 || $i==27 || $i==34 || $i==41)
											echo "'>$j";								
										else
											//echo "'>$j<a href=\"javascript:anadir_cita('$pedf','$presuf','$clientf','$compuesta','$usuarioATSA')\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>";
											echo "'>$j<a  id='add_cita$j' onClick=\"anadir_cita(this)\" title='".$cliente->dic_textos['agregar_cita_el'].' '.fecha($compuesta)."' rel='".$compuesta."' class='add agregar_evento'><img src='img/img_calendario/add.png' /></a>";
									}

								}
						}				

					}
					
					//echo "<script type=\"text/javascript\">alert('.$compuesta.')</script>";
					//echo "<p>$item->AgdComentario<a href='".$_SERVER["PHP_SELF"]."?borrarevento=".$item->AgdFecha."' onClick=\"return confirm('&iquest;Confirmas la eliminaci&oacute;n del Evento?')\" title='Eliminar este Evento del ".fecha($compuesta)."' class='vtip'><img src='img/img_calendario/delete.png' /></a></p>";
					/*$sqlevent="select * from tcalendario where fecha='".$compuesta."' order by id";
					mysql_select_db($dbname);
					$revent=mysql_query($sqlevent);*/
					/*$h=0;
					while(count($citag) > $h)
					{
						$s =$citag[$h]['AgdComentario'];
						echo "<p>$s<a href='".$_SERVER["PHP_SELF"]."?borrarevento=".$citag[$h]["AgdFecha"]."' onClick=\"return confirm('&iquest;Confirmas la eliminaci&oacute;n del Evento?')\" title='Eliminar este Evento del ".fecha($compuesta)."' class='vtip'><img src='img/img_calendario/delete.png' /></a></p>";
						$h+=1;
					}*/
					
					echo "</td>";
					$j+=1;
				}
				else echo "<td class='desactivada'>&nbsp;</td>";
				if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42) {echo "<tr>";$filita+=1;}
				}
			}
			echo "</table>";
			$mesanterior=date("Y-m-d",mktime(0,0,0,$mesactual-1,01,$elanio));
			$messiguiente=date("Y-m-d",mktime(0,0,0,$mesactual+1,01,$elanio));
			echo "<div style=\"width:50%;\">";
			echo "<p class=\"toggle\">&laquo; <a class='anterior' href='".$_SERVER["PHP_SELF"]."?fecha=$mesanterior'>".$cliente->dic_textos['mes_anterior']."</a> - <a class='siguiente' href='".$_SERVER["PHP_SELF"]."?fecha=$messiguiente'>".$cliente->dic_textos['mes_siguiente']."</a> &raquo;</p>";
			echo "</div>";
			?>	
		<div id="mask"></div>
	<div>	

</body>
</html>