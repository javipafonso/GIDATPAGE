<?php


$link = mysql_connect('localhost', 'c3agendaventa', 'kqwgZCI_52') or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('c3nuestragenda') or die('No se pudo seleccionar la base de datos');

$msg= $_POST['nombre'];
// Realizar una consulta MySQL
$query = mysql_query('SELECT Max(UsrId) FROM Usr'.$msg);
$ultimo_id=1;
if (empty($query))
	$ultimo_id=1;
else{
	$ultimo_id=mysql_result($query, 0);
	$ultimo_id=$ultimo_id + 1;
}
	
 	
 	//$s = date_format($date,'yyyy-mm-dd');
 	$date = $_POST['fecha']." ".$_POST['horas'].":".$_POST['minutos'].":".date("s");
    $dates = date_format($date,'Y-m-d H:i:s');

    // sql to create table
    $sql = "INSERT INTO Usr".$msg;
    $sql .= " SET UsrId  =  '".$ultimo_id."',";
    $sql .= " UsrFirstName = '".$_POST['UsrFirstName']."',";
    $sql .= " UsrFirstSurName = '".$_POST['UsrFirstSurName']."',";
    $sql .= " UsrSecondSurName = '".$_POST['UsrSecondSurName']."',";
    $sql .= " UsrEmail = '".$_POST['UsrEmail']."',";
    $sql .= " UsrTelefono = '".$_POST['UsrTelefono']."',";
    $sql .= " UsrRegDate = '".$dates."'";
    
   
    // // // use exec() because no results are returned
    $resultado = mysql_query($sql);
    if ($resultado){
        $variable = "INSERTED ROW";
        echo $variable;
    }
    else{
        $msg = mysql_error();
        echo $msg;   
    }
    

?>