<?php
include_once('../db_func.php');

$name = $conn->real_escape_string( $_POST['name'] );
$email = $conn->real_escape_string( $_POST['email'] );
$password = md5( $_POST['password'] );

$query = "INSERT `b_user` SET 
    `u_name` = $name,
    `u_email` = $email,
    `u_password` = $password,
    `u_insert_datetime` = current_timestamp()
";

$result = DB_INSERT( $query );

if( $reuslt ) echo "SUCCESS";
else echo "FAILED";

?>