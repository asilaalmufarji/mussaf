<?php 
require_once 'config.php';

function dbQuery_PDO_no($sql)
{
	global $con;	
	
	//echo $sql;
	$stmt = $con->prepare($sql);
	//echo $sql;
	$stmt->execute();
	return $stmt;
}

function dbQuery_PDO($sql , $add_array)
{
	
	global $con;
	//echo $sql;
	$stmt = $con->prepare($sql);
	$stmt->execute($add_array);
	return $stmt;
}
function dbQuery($sql )
{
	
	global $con;
	//echo $sql;
	$stmt = $con->prepare($sql);
	$stmt->execute();
	return $stmt;
}


function dbNumRows_PDO($result)
{
	return $result->fetchColumn();
}
