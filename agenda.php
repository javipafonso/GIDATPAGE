<?php
session_start();
 $link = mysql_connect('localhost', 'c3javier', 'm9cVCvrwtEAA') or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('c3calendario') or die('No se pudo seleccionar la base de datos');
// $query = 'SELECT * FROM agenda';
// $msg = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
// echo $msg;
// $user_agent = $_SERVER['HTTP_USER_AGENT'];
// $posicion = strrpos($user_agent, "MSIE");		
// if ($posicion === false)
// 	$ie=false;
// else
// 	$ie=true;
?>
<html>
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
	<link rel="stylesheet" href="css/estilo_agenda.css" type="text/css"  />
	<link rel="stylesheet" href="css/estilo.css" type="text/css"  />
	<link rel="stylesheet" href="css/estilos.css" type="text/css"  />
	<link rel="stylesheet" href="css/base.css" type="text/css"  />
	<link rel="stylesheet" href="css/form.css" type="text/css"  />

</head>
<div id="page" class="anchoFix clearfix">
	
	<div class="bloque">
		
		<div class="divBar clearfix">
			<table class="barra" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="nowrap">
						<a class="btn" href="" target="" alt="">Ver todo</a>						
					</td>
					<td class=""></td>
					<td class="nowrap">
					</td>
					<td class="nowrap">						
						Citas días anteriores: 
					</td>
					<td class="nowrap">						
						Citas pendientes del día: 
					</td>
					<td class="nowrap">						
						Citas días posteriores: 
					</td>
				</tr>
			</table>			
		</div>

	<div class="divBar clearfix">
			<!--<table class="barra" width="100%" cellpadding="0" cellspacing="0" border="0">-->
			<?php
			
			    								
				/*if(!isset($_GET['r']))     
{  
$pagina = $_SERVER['PHP_SELF'];

echo "<script type='text/javascript'>     
<!--      
document.location=\"$pagina?r=1&width=\"+screen.width;     
//-->     
</script>";     
}     */
	
				switch (1) {
   					case 1: 
   							//$width=isset($_GET['width'])?$_GET['width']:0;
   							//if ($width <= 1024){									
   							//	echo "<div class='divBar clearfix ancho'>";
			         		//}else{
			         			echo "<div class='divBar clearfix lang_es'>";
			         		//}
			         	break;
				   case 2:				   		
				   		//$width=isset($_GET['width'])?$_GET['width']:0;
				   		//if ($width <= 1024){									
   								//echo "<div class='divBar clearfix ancho_en'>";
			         	//	}else{
				   				echo "<div class=\"divBar clearfix lang_en\">";
				   		//	}
				         break;
				   case 3:
				   		//$width=isset($_GET['width'])?$_GET['width']:0;
				   	//	if ($width <= 1024){									
   								echo "<div class='divBar clearfix ancho_fr'>";
			         //		}else{
				   		
				       //  		echo "<div class=\"divBar clearfix lang_fr\">";
				         //	}
				         break;

				//<div class="divBar clearfix" style="text-align:center;float:right;width:15%;margin:6px 651px 3px 0;">-->
			}?>
				<table class="barra" cellpadding="0" cellspacing="0" border="0">
				<tr>
				Leyenda:
				</tr>
				<tr>
					<?php switch (1){
						case 1:
						if	($ie)
							echo "<td class='leyenda_es_ie'>";
						else
							echo "<td class='leyenda_es'>";
						break;
						case 2:
						if	($ie)
							echo "<td class='leyenda_en_ie'>";
						else
							echo "<td class='leyenda_en'>";
						break;
						case 3:
						if ($ie)
							echo "<td class='leyenda_fr_ie'>";
						else
							echo "<td class='leyenda_fr'>";
						break;
					}?>
					<img src="img/naranja.png"/> Día actual
					</td>
				</tr>	
				<tr>
					<td class="nowrap">
					<img src="img/rojo.png"/> Día con citas
					</td>
				</tr>				
			</table>	
			</div>
			<?php include("agdcalendario.php");?>
			
			<!--</table>-->
		</div>
	</div>
</div>

<?php include("_footer.php");?>

</body>
</html>

</body>
</html>