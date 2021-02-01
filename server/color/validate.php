<?php
require_once('../config.php');

$idx = $_POST['idx'];

$query = "UPDATE `b_bipv_color` SET `c_approval`='Y' WHERE `c_no`='$idx';";

$result = $conn->query( $query );
echo $result;
?>