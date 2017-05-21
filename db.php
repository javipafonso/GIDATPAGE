<?php
//echo $msg;
session_start();
 $link = mysql_connect('localhost', 'c3agendaventa', 'kqwgZCI_52') or die('No se pudo conectar: ' . mysql_error());

mysql_select_db('c3nuestragenda') or die('No se pudo seleccionar la base de datos');


// Realizar una consulta MySQL
$query = 'SELECT UsrPApellido FROM users where UsrNombre = "'.$_POST['name'].'"';
$msg = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
$_SESSION['name'] = $_POST['name'];
$rows = mysql_num_rows($msg);
if ($rows > 0)
{
	// sql to create table
 try{

    // sql to create table
    $sql = "CREATE TABLE Usr".$_POST['name']." (
    UsrId INT(6) UNSIGNED DEFAULT '1' NOT NULL PRIMARY KEY, 
    UsrFirstName VARCHAR(30) DEFAULT '' NOT NULL,
    UsrFirstSurName VARCHAR(30) DEFAULT '' NOT NULL,
    UsrSecondSurName VARCHAR(30) DEFAULT '' NOT NULL,
    UsrEmail VARCHAR(50) DEFAULT '' NOT NULL,
    UsrTelefono VARCHAR(50) DEFAULT '' NOT NULL,
    UsrObservaciones VARCHAR(50) DEFAULT '' NOT NULL,
    UsrHecha CHAR(1) DEFAULT 'N' NOT NULL,
    UsrReg_date TIMESTAMP
    )";

    // use exec() because no results are returned
    $resultado = mysql_query($sql);
    if ($resultado){
        $msg = "Table MyGuests created successfully";
        echo $msg;
    }
    else{
        $msg = "Table Exists";
        echo $msg;   
    }
    }
catch(PDOException $e)
    {
    $msg = $e->getMessage();
    echo $sql . "<br>" . $msg;
    }
	

}



?>