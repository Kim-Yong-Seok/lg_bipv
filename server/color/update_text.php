<?php
require_once('../config.php');

$c_client_type = $_POST['client_type'];
$c_client_value = $_POST['client_value'];
$c_tag = $_POST['tag'];
$c_memo = $_POST['memo'];
$idx = $_POST['idx'];

$query = "UPDATE `b_bipv_color` SET 
    `c_client_type` = '$c_client_type',
    `c_client_Value` = '$c_client_value',
    `c_tag` = '$c_tag',
    `c_memo` = '$c_memo'
    WHERE `c_no` = '$idx';";

$result = $conn->query( $query );

echo $result;
?>