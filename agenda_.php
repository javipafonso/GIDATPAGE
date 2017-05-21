<?
include("./include/session.php");
$presupuestos = true; // $cliente->sacaPresupuestos();
$tituloMetas = $cliente->dic_textos['agenda'] ;
$agendas = $cliente->editarCitaAgenda();
$citaspendientes = $agendas->agendaPendientes($cliente->usuario->UsrLogin);
$citaspendientesant = $agendas->agendaPendientesdia($cliente->usuario->UsrLogin,true);
$citaspendientespost = $agendas->agendaPendientesdia($cliente->usuario->UsrLogin,false);
include("include/metas.php");
$CurSec = "agenda" ;
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$posicion = strrpos($user_agent, "MSIE");		
if ($posicion === false)
	$ie=false;
else
	$ie=true;
?>
</head>

<body>

<? include("_header.php");?>

<div id="page" class="anchoFix clearfix">
	
	<div class="bloque">
		
		<div class="divBar clearfix">
			<table class="barra" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="nowrap">
						<a class="btn" href="" target="" alt=""><?=$cliente->dic_textos['ver_todo']?></a>						
						<!--<? if($cliente->usuario->nivel >= 10 ){?>
							<?include("_formCitaAgenda.php");?>
						<?}?>-->										
					</td>
					<td class=""></td>
					<td class="nowrap">
					</td>
					<td class="nowrap">						
						<?=$cliente->dic_textos['citas_pendientes_dias_ant']?>: <?=$citaspendientesant[0]["CUANTOS"]?>			
					</td>
					<td class="nowrap">						
						<?=$cliente->dic_textos['citas_pendientes_dia']?>: <?=$citaspendientes[0]["CUANTOS"]?>			
					</td>
					<td class="nowrap">						
						<?=$cliente->dic_textos['citas_pendientes_dias_post']?>: <?=$citaspendientespost[0]["CUANTOS"]?>			
					</td>
				</tr>
			</table>			
		</div>

		<div class="divBar clearfix">
			<!--<table class="barra" width="100%" cellpadding="0" cellspacing="0" border="0">-->
			<?
			
			    								
				/*if(!isset($_GET['r']))     
{  
$pagina = $_SERVER['PHP_SELF'];

echo "<script type='text/javascript'>     
<!--      
document.location=\"$pagina?r=1&width=\"+screen.width;     
//-->     
</script>";     
}     */
	
				switch ($cliente->idioma) {
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
				<?=$cliente->dic_textos['leyenda']?>:
				</tr>
				<tr>
					<?switch ($cliente->idioma ){
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
					<img src="img/naranja.png"/> <?=$cliente->dic_textos['dia_actual']?>
					</td>
				</tr>	
				<tr>
					<td class="nowrap">
					<img src="img/rojo.png"/> <?=$cliente->dic_textos['dia_con_citas']?>
					</td>
				</tr>				
			</table>	
			</div>
			<?include("agdcalendario.php");?>
			
			<!--</table>-->
		</div>
	</div>
</div>

<? include("_footer.php");?>

</body>
</html>