<?php

include("php/dbconnect.php");

$sql = "SELECT * FROM student WHERE delete_status = '0'";
$query = $conn->query($sql);
echo "$query->num_rows";
