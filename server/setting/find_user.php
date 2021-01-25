<?php
require_once('../config.php');

$u_name = $_POST['name'];

$query = "SELECT * FROM `b_user` WHERE `u_name`='$u_name';";
$result = $conn->query( $query );
if( isset( $result ) ) {
    $res = $result->fetch_array( MYSQLI_ASSOC );
    echo json_encode($res, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
}

?>