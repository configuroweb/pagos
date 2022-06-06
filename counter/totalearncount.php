<?php

$servername = "localhost";
$uname = "root";
$pass = "";
$database = "pagos";

$conn = mysqli_connect($servername, $uname, $pass, $database);

if (!$conn) {
    die("Connection Failed");
}

$sql = "SELECT SUM( paid) FROM fees_transaction";
$amountsum = mysqli_query($conn, $sql) or die(mysqli_error($sql));
$row_amountsum = mysqli_fetch_assoc($amountsum);
$totalRows_amountsum = mysqli_num_rows($amountsum);
echo '$' . $row_amountsum['SUM( paid)'];
