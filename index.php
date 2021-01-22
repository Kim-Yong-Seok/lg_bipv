<?php
require_once('./server/config.php');
session_start();

if( $_SESSION['no'] ) {
    go_to('home.php');
} else {
    go_to('login.php');
}

?>