<?php

include("php/dbconnect.php");

$sql = "SELECT * FROM grade";
$query = $conn->query($sql);
echo "$query->num_rows";
