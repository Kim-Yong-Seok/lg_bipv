<?php
include_once('./config.php');

function DB_INSERT( $query ) {
    $result = $conn->query( $query );
    return;
}

function DB_UPDATE( ) {
    
    return;
}

function DB_DELETE( ) {

    return;
}

function DB_SELECT( $query ) {
    $result = $conn->query( $query );
    return $result;
}

?>