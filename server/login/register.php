<?php
require_once('../config.php');

$name = $conn->real_escape_string( $_POST['name'] );
$email = $conn->real_escape_string( $_POST['email'] );
$password = md5( $_POST['password'] );

$query = "SELECT * FROM `b_user` WHERE `u_email` = '$email'";
$result = $conn->query( $query );

if( isset( $result ) && $result->num_rows > 0 ) {
    alert('동일한 계정이 존재합니다.');
    go_to('../../login.php');
    return;
}

$query = "INSERT `b_user` SET 
    `u_name` = '$name',
    `u_email` = '$email',
    `u_password` = '$password'
";

$result = $conn->query( $query );

echo $result;

?>