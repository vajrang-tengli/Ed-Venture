<?php
$hostName="localhost";
$dbUser="root";
$dbPassword="chimmi@2009";
$dbName="login_register";
$conn=mysqli_connect($hostName, $dbUser,$dbPassword,$dbName);
if(!$conn)
{
    die("Something went wrong;");
}

?>