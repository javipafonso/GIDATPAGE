
<head id="header">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="UTF-8">		
	<div class="header clearfix">
		<div class="anchoFix clearfix">
			<div class="shell clearfix">
				
				<div class="txtC clearfix">
						<img src="img/logo-header.png" width="" height="" alt="" title="" longdesc="" border="0" />
				</div>
				
			</div>
		</div>
	</div>

	<link rel="stylesheet" href="css/estilo.css" type="text/css"  />
	<link rel="stylesheet" href="css/estilos.css" type="text/css"  />
	<link rel="stylesheet" href="css/base.css" type="text/css"  />
	<link rel="stylesheet" href="css/form.css" type="text/css"  />

</head>
<script type="text/javascript" src="js/md5.js"></script>
<script type="text/javascript" src="jquery/jquery-1.12.3.js"></script>
<script type="text/javascript">
	function getMD5 () {
		var nombre = document.getElementById("usuario").value;
		var hash = calcMD5(nombre);	
		 alert(hash);
        $.ajax({
			  method: "POST",
			  url: "db.php",
			  data: { name: nombre, location: "Boston" }
			})
			  .done(function( msg ) {				  
			    $("#resultado").html(msg);
			    window.open("agenda.php");
			  });
			  

        
	}
</script>
<body>
	<div id="page" class="anchoFix clearfix">
	
	<div class="bloque">
		
		<div class="clearfix">
			<form method="post" action="">
				<table class="tableLogin" style="margin:2em auto;">
					<tr>
						<td class="txtR">Usuario</td>
						<td>
							<input class="form" name="usuario" id="usuario" type="text" value="" />
							
						</td>
					</tr>
					<tr>
						<td class="txtR">Contraseña</td>
						<td><input class="form" name="pass" id="pass" type="password" value="" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="button" class="btn" onclick="getMD5()" value="Entrar"></input>
					</tr>
					<tr>
						<td></td>
						<td ><p id="resultado">hola</p></td>
					</tr>
				</table>
			</form>
		</div>
		
	</div>
	
</div>




</body>

</html>