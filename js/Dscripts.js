(function( $ ) {
Dcli = {
	loading : function(modo){
		if( modo == "hide" )
			$('#cargando').css('display' , 'none' )
		else 
			$('#cargando').css('display' , 'block' )
	}  , 
	resetUi: function( selector ){
		try
		{
			$( selector ).dialog( "destroy" );
		}
		catch (e)
		{
		}
	} ,  
	alerta : function(texto , callback ){
		$('#alertaCtxt').html(texto)
		this.resetUi("#alertaC") ; 	
		$( "#alertaC" ).dialog({
			modal: true,
			close: function( event, ui ) {
				if( callback )
					callback() 
			}, 
			 buttons: {
				Ok: function() {
				$( this ).dialog( "close" );
			}
			}
		});

	} , 
	confirm : function( opciones , callbackYES , callbackNO ){
		$('#alertaCtxt').html(opciones.texto)
		texto_si = opciones.textoSi || 'Si' ;
		texto_no = opciones.textoNo || 'No' ;
		this.resetUi("#alertaC") ;
		$( "#alertaC" ).dialog({ /// jQuery UI 
			modal: true, 
			width: 300 ,
			  buttons: [
					{ text: texto_si ,  
					click: function() {
							if( callbackYES )
								callbackYES() ; 
							$( this ).dialog( "close" );
						}
					},
					{
					 text: texto_no ,
					 click: function() {
							if( callbackNO )
								callbackNO();
							$( this ).dialog( "close" );
						}
					}
				]
		});

	}  , 
	altaComentario : function( opciones , callbackYES , callbackNO ){
		texto_si = opciones.textoSi || 'Enviar' ;
		texto_no = opciones.textoNo || 'Cancelar' ;
		this.resetUi("#comentariosFlotanteC") ;
		$( "#comentariosFlotanteC" ).dialog({ /// jQuery UI 
			modal: true, 
			width: 300 ,
			  buttons: [
					{ text: texto_si ,  
					click: function() { 
							if( callbackYES ) { 
								if( callbackYES() == true )
									$( this ).dialog( "close" );
							}
							else 
								$( this ).dialog( "close" );
						}
					},
					{
					 text: texto_no ,
					 click: function() {
							if( callbackNO )
								callbackNO();
							$( this ).dialog( "close" );
						}
					}
				]
		});

	}  , 
	customConfirm : function( texto , botones ){
		$('#alertaCtxt').html(texto)
		this.resetUi("#alertaC") ;
		$( "#alertaC" ).dialog({
			modal: true, 
			buttons: botones 
		});
	}  , 
	enFoca : function( el ){

			el.addClass("ui-focus-error");
	} , 
	desEnFoca : function ( el ){

			el.removeClass("ui-focus-error");
	} , 
	validacion_general : function(idForm){
		var error = false ; 
		var that = this ; 
		$( idForm + " input.required:not(:disabled)," + idForm + " select.required:not(:disabled)," + idForm + " textarea.required:not(:disabled)").each(function(index,el){
			
			if( !$(this).val()){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})

		$( idForm + ' input[type="radio"].required:not(:disabled)').each(function(index,el){
			
			if( $('input[name="' + $(this).attr("name") + '"]:checked').length == 0 )
			{
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})
		/// digitos 
		$( idForm + " input.digito:not(:disabled)").each(function(index,el){
			
			if( !that.validaDigitos( $(this).val() , !$(this).hasClass("required")    ) ){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})
		/// enteros 
		$( idForm + " input.entero:not(:disabled)," + idForm + " input.integer:not(:disabled)").each(function(index,el){
			
			if( !that.validaInteger( $(this).val() , !$(this).hasClass("required") ) ){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})
		// float 
		$( idForm + " input.number:not(:disabled)").each(function(index,el){
			that.limpiaNumero($(this))
			if( !that.validaFloat( $(this).val() , !$(this).hasClass("required") ) ){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})
		/// mail 
		$( idForm + " input.mail:not(:disabled)").each(function(index,el){
			
			if( !that.validaEmail( $(this).val() , !$(this).hasClass("required") ) ){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})
		/// fecha
		$( idForm + " input.fecha:not(:disabled)").each(function(index,el){
			if( !that.validaFecha( $(this).val() , !$(this).hasClass("required") ) ){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})
		/// mayor que cero 
		$( idForm + " input.mayorCero:not(:disabled)").each(function(index,el){
			if( $(this).val() == 0 ){
				that.enFoca( $(this) )
				error = true ; 
				
			} else {
				that.desEnFoca( $(this) ) ;
			}
		})


		return error ; 
	} , 
	validaInteger : function(val , vacio ){
	
			return ( vacio && $.trim(val) == "" ) || (/^(-?[1-9]\d*|0)$/).test(val)
	},
	validaFloat : function(val , vacio ){
			return ( vacio && $.trim(val) == "" ) || (/^-?(?:0$0(?=\d*\.)|[1-9]|0)\d*(\.\d+)?$/).test(val) || this.validaInteger( val , vacio );
	} ,
	validaDigitos : function(val , vacio ){
			return ( vacio && $.trim(val) == "" ) || (/^[\d() .:\-\+#]+$/.test(val));
	},
	validaEmail : function (val , vacio ){
			return ( vacio && $.trim(val) == "" ) || (/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]\.?){0,63}[a-z0-9!#$%&'*+\/=?^_`{|}~-]@(?:(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)*[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\])$/i).test(val);
	}, 
	validaFecha : function(txtDate , vacio ){
			if( vacio && $.trim(txtDate) == "" )
				return true ;
			var dateParts = txtDate.split('/');
			if(dateParts.length != 3) {
				return false;
			}
			var y = parseInt(dateParts[2],10)
			var m = parseInt(dateParts[1],10) - 1 
			var dia = parseInt(dateParts[0],10) 
			var d=new Date();
			d.setFullYear(y ,m ,dia ); 
			return  d.getFullYear() == y && d.getMonth() == m && d.getDate() == dia 
	} , 
	limpiaNumero: function(el){
			el.val(el.val().replace(",",".") )	
		} , 
	borrar: function (id){
	
				$(id).slideToggle( function(){ $(this).remove() } ) ;
			} , 
	borrarPadre: function (el){
			$(el).closest("div").remove();
		}
}

})( jQuery );


//Code Starts

function validaSize(el, limit ) {
	try {
			
			var f = -1;
			// alert(navigator.appName); // to get the browser name
			var oas;
			try {
			/* ----------------Internet Explorer ---------------- */
				if (navigator.appName == "Microsoft Internet Explorer") {
					oas = new ActiveXObject("Scripting.FileSystemObject");
					var d = j(el).val();
					var e = oas.getFile(d);
					f = e.size;
					if ((f / (1024 * 1024)) > limit) {
						return false;
					}
					else {
						return true;
					}
				}
				/* ---------------- Other ---------------- */
				else {
					//Modificado por Javier Pérez Afonso para ver más de un archivo
					
					for (var i = 0; i < j(el)[0].files.length; i++){ 
						var filesize = j(el)[0].files[i].size; // b.files[0].Size;						
						if ((filesize / (1024 * 1024)) > limit ) {
						 	return false;
						 }
						 else {
						 	return true;
						 }
					}
				// return true;
				}
			}
			catch (err1) {
				//console.log( err1)
				//alert('Tools -> Internet Options -> choose the Security tab Click the Custom Level button Enable the following settings: Run ActiveX controls and plug-ins Initialize and script ActiveX controls not marked as safe.');
				return true;
			}
	}
	catch (err) {
		//alert(err.ToString);
		return true;
	}
}

function procesaPaginacion(data){
	if (data && data.hasOwnProperty('rows')) {
	  var r, row, c, d = data.rows,
	  // total number of rows (required)
	  total = data.total_rows,
	  // array of header names (optional)
	  //headers = data.headers,
	  // all rows: array of arrays; each internal array has the table cell data for that row
	  rows = [],
	  // len should match pager set size (c.size)
	  len = d.length;
	  // this will depend on how the json is set up - see City0.json
	  // rows
	  for ( r=0; r < len; r++ ) {
		  //console.log( d[r])
		row = d[r]; // new row array
		// cells
		/*
		for ( c in d[r] ) {
		  console.log(d[])
		  if (typeof(c) === "string") {
			row.push(d[r][c]); // add each table cell data to row array
		  }
		}*/
		rows.push(row); // add new row array to rows array
	  }
	  return [ total, rows ];
	}
  }

  function procesaPaginacionP(data){
	if (data && data.hasOwnProperty('rows')) {
	  var r, row, c, d = data.rows,
	  // total number of rows (required)
	  total = data.total_rows,
	  // array of header names (optional)
	  //headers = data.headers,
	  // all rows: array of arrays; each internal array has the table cell data for that row
	  rows = [], opciones = []
	  // len should match pager set size (c.size)
	  len = d.length , opcionesO = data.opciones ;
	  // this will depend on how the json is set up - see City0.json
	  // rows
	  for ( r=0; r < len; r++ ) {
		  //console.log( d[r])
		row = d[r]; // new row array
		// cells
		/*
		for ( c in d[r] ) {
		  console.log(d[])
		  if (typeof(c) === "string") {
			row.push(d[r][c]); // add each table cell data to row array
		  }
		}*/
		rows.push(row); // add new row array to rows array
		opciones.push(opcionesO[r]); // add new row array to rows array
	  }
	  return [ total, rows , false , opciones ];
	}
  }


