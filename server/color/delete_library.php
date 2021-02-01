<?php
require_once('../config.php');

$query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='Y';";
$result = $conn->query( $query );

while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
    $chk_sum = 'check_'.$res['c_no'];
    $no = $res['c_no'];
    if( isset($_POST[$chk_sum]) ) {
        $query = "DELETE FROM `b_bipv_color` WHERE `c_no` = $no;";
        $conn->query( $query );
        // echo $query;
    }
}
?>