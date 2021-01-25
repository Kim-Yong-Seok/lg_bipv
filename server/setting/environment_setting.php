<?php
session_start();
require_once('../config.php');

$e_glass_type = $_POST['glass_type'];
$e_glass_thickness = $_POST['thickness'];
$e_glass_texture = $_POST['texture'];
$e_printing_type1 = $_POST['printing_type'];
$e_printing_type1_text = $_POST['printing_text'];
$e_printing_type2 = $_POST['printing_value'];
$e_pattern = $_POST['pattern'];
$e_continent = $_POST['continent'];
$e_country = $_POST['country'];
$e_country_text = $_POST['country_text'];
$e_illuminant = $_POST['illuminant'];
$e_illuminant_text = $_POST['illuminant_text'];
$e_distance = $_POST['distance'];

$query = "UPDATE `b_environment` SET 
    `e_glass_type` = '$e_glass_type',
    `e_glass_thickness` = '$e_glass_thickness',
    `e_glass_texture` = '$e_glass_texture',
    `e_printing_type1` = '$e_printing_type1',
    `e_printing_type1_text` = '$e_printing_type1_text',
    `e_printing_type2` = '$e_printing_type2',
    `e_pattern` = '$e_pattern',
    `e_continent` = '$e_continent',
    `e_country` = '$e_country',
    `e_country_text` = '$e_country_text',
    `e_illuminant` = '$e_illuminant',
    `e_illuminant_text` = '$e_illuminant_text',
    `e_distance` = '$e_distance'
";

$result = $conn->query( $query );
// echo $query;
if( $result ) {
    // alert('Successfully updated');
    go_to('../../home.php');
} else {
    // alert('Update failed');
    go_to('../../environment.php');
}


?>