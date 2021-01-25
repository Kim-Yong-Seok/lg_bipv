<?php
require_once('../config.php');
$effectiveness = $_POST['effectiveness'];

$query = "SELECT * FROM `b_user` WHERE `u_effectiveness`='$effectiveness';";
$result = $conn->query( $query );

$value = array();
if( isset($result) && $result->num_rows > 0) {
    $i=0;
    while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
        $value[$i]['u_name'] = $res['u_name'];
        $value[$i]['u_email'] = $res['u_email'];
        $value[$i]['u_state'] = $res['u_state'];
        $i++;
    }
    
    echo json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
}

?>