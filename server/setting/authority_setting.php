<?php
require_once('../config.php');

$u_email = $_POST['u_email'];
$u_effectiveness = 'Y';
$u_authority = $_POST['u_authority'];

$query = "UPDATE `b_user` SET 
    `u_effectiveness` = '$u_effectiveness',
    `u_state` = '$u_authority'
    WHERE `u_email`='$u_email';";

$result = $conn->query( $query );
echo $result;

?>