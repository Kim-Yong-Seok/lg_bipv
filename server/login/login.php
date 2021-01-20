<?php
require_once('../config.php');
session_start([
    'cookie_lifetime' => 86400
]);

$email = $conn->real_escape_string( $_POST['email'] );
$pw = md5( $_POST['password'] );

$query = "SELECT * FROM `b_user` WHERE `u_email` = '$email' and `u_password` = '$pw' LIMIT 1";
$result = $conn->query( $query );

if( $result->num_rows > 0 ) {
    $res = $result->fetch_array( MYSQLI_BOTH );
    $_SESSION['email'] = $res['u_email'];
    $_SESSION['name'] = $res['u_name'];
    $_SESSION['no'] = $res['u_no'];
    $_SESSION['state'] = $res['u_state'];
    $_SESSION['effectiveness'] = $res['u_effectiveness'];
    go_to('../../home.php');
} else {
    alert('일치하는 정보가 없습니다.');
    echo "<script>history.back(-1);</script>";
}


?>