<?
	// PHP 7.0
	$servername = "localhost";
	$username = "daejeoninega";
	$password = "emwpdl(())";
	$database = "daejeoninega";

	$conn = new mysqli($servername, $username, $password, $database);
	if($conn->connect_error)
	  die("접속오류 : " . $conn->connect_error);
	else
	  //echo "<h1>MYSQL 접속 성공</h1>";	
?>