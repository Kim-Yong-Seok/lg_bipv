<?php
session_start();
require_once('../config.php');

$c_input_color_type = $_POST['color_type_value'];
$c_pv = $_POST['pv_value'];
$c_adjust_brightness = $_POST['brightness_value'];
$c_adjust_saturation = $_POST['saturation_value'];
$c_adjust_hue = $_POST['hue_value'];
$expected_power = $_POST['expected_power'];
$c_client_type = $_POST['client_type'];
$c_client_value = $_POST['client_value'];
$c_tag = $_POST['tag'];
$c_memo = $_POST['memo'];
$c_color_name = $_POST['pjt_name'];

$fixed_hex_value = $_POST['fixed_hex_value'];
$none_fixed_hex_value = $_POST['none_fixed_hex_value'];

if( $c_input_color_type == "rgb" || $c_input_color_type == "lab" ) {
    $c_input_color_value1 = $_POST['ibv1_1'];
    $c_input_color_value2 = $_POST['ibv1_2'];
    $c_input_color_value3 = $_POST['ibv1_3'];
    $c_input_color_value4 = '';
} else if( $c_input_color_type == "cmyk" ) {
    $c_input_color_value1 = $_POST['ibv2_1'];
    $c_input_color_value2 = $_POST['ibv2_2'];
    $c_input_color_value3 = $_POST['ibv2_3'];
    $c_input_color_value4 = $_POST['ibv2_4'];
} else {
    $c_input_color_value1 = $_POST['ibv3_1'];
    $c_input_color_value2 = $_POST['ibv3_2'];
    $c_input_color_value3 = '';
    $c_input_color_value4 = '';
}

if( isset($_POST['target_value']) ) {
    $c_target = 'S';
    $c_target_hex_code = $none_fixed_hex_value;
    $c_surface_hex_code = $fixed_hex_value;
} else {
    $c_target = 'T';
    $c_target_hex_code = $fixed_hex_value;
    $c_surface_hex_code = $none_fixed_hex_value;
}

$c_user_no = $_SESSION['no'];

$query = "INSERT `b_bipv_color` SET 
    `c_user_no` = '$c_user_no',
    `c_color_name` = '$c_color_name',
    `c_target` = '$c_target',
    `c_input_color_type` = '$c_input_color_type',
    `c_input_color_code1` = '$c_input_color_value1',
    `c_input_color_code2` = '$c_input_color_value2',
    `c_input_color_code3` = '$c_input_color_value3',
    `c_input_color_code4` = '$c_input_color_value4',
    `c_target_hex_code` = '$c_target_hex_code',
    `c_pv` = '$c_pv',
    `c_adjust_brightness` = '$c_adjust_brightness',
    `c_adjust_saturation` = '$c_adjust_saturation',
    `c_adjust_hue` = '$c_adjust_hue',
    `c_surface_hex_code` = '$c_surface_hex_code',
    `c_expected_power` = '$expected_power',
    `c_client_type` = '$c_client_type',
    `c_client_value` = '$c_client_value',
    `c_tag` = '$c_tag',
    `c_memo` = '$c_memo'
";
$result = $conn->query( $query );
if( $result ) {
    echo "1";
}

?>