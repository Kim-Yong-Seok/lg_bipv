<?php
session_start();
require_once('../config.php');

$conn->close();
session_destroy();

alert('로그아웃 되었습니다.');
go_to('../../login.php');
?>