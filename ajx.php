<?php

include("php/dbconnect.php");

if($_GET['type'] == 'studentname'){
	$result = $conn->query("SELECT sname,contact FROM student where balance>0 and (sname LIKE '%".$_GET['name_startsWith']."%' or contact LIKE '%".$_GET['name_startsWith']."%')   ");	
	$data = array();
	while ($row = $result->fetch_assoc()) {
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['sname']);	
	}	
	echo json_encode($data);
}


if($_GET['type'] == 'report'){
	$result = $conn->query("SELECT sname,contact FROM student where (sname LIKE '%".$_GET['name_startsWith']."%' or contact LIKE '%".$_GET['name_startsWith']."%')   ");	
	$data = array();
	while ($row = $result->fetch_assoc()) {
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['sname']);	
	}	
	echo json_encode($data);
}


?>