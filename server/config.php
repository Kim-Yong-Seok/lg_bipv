<?php
$SERVER_ADDRESS = "localhost";
$USER = "dejay";
$PASSWORD = "dejay2018@@";
$DATABASE = "dejay";

$conn = new mysqli( $SERVER_ADDRESS, $USER, $PASSWORD, $DATABASE );

if( $conn->connect_error ) {
    echo "Error: Unable to connect to MySQL.";
    echo "<br>Debugging error No: ".$conn->connect_errno;
    echo "<br>Debugging error: ".$conn->connect_error;
    exit;
}

function alert( $msg ) {
    echo "<script>alert('".$msg."')</script>";
}

function go_to( $link ) {
    echo "<script>location.href='".$link."'</script>";
}
?>