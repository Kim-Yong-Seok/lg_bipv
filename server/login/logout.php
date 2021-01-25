<?php
session_start();
require_once('../config.php');

$conn->close();
session_destroy();

go_to('../../login.php');
?>