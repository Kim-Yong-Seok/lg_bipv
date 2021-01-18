<?php
include_once('../db_func.php');

$color_type = $_POST['color_type'];
$color_code = $_POST['color_code'];
$target_code_lab = $_POST['target_code_lab'];
$target_code_cmyk = $_POST['target_code_lab'];
$target_code_rgb = $_POST['target_code_rgb'];
$target_hex_code = $_POST['target_hex_code'];
$pv = $_POST['pv'];
$adjust_brightness = $_POST['adjust_brightness'];
$adjust_saturation = $_POST['adjust_saturation'];
$surface_code_lab = $_POST['surface_code_lab'];
$surface_code_cmyk = $_POST['surface_code_cmyk'];
$surface_code_rgb = $_POST['surface_code_rgb'];
$surface_hex_code = $_POST['surface_hex_code'];
$expected_power = $_POST['expected_power'];
$client_type = $_POST['client_type'];
$client_value = $_POST['client_value'];
$tag = $_POST['tag'];
$memo = $_POST['memo'];
$datetime = current_timestamp();

$no = $_SESSION['u_no'];

$query = "INSERT `b_bipv_color` SET 
    `c_user_no` = $no,
    `c_input_color_type` = $color_type,
    `c_input_color_code` = $color_code,
    `c_target_code_lab` = $target_code_lab,
    `c_target_code_cmyk` = $target_code_cmyk,
    `c_target_code_rgb` = $target_code_rgb,
    `c_target_hex_code` = $target_hex_code,
    `c_pv` = $pv,
    `c_adjust_brightness` = $adjust_brightness,
    `c_adjust_saturation` = $adjust_saturation,
    `c_surface_color_lab` = $surface_code_lab,
    `c_surface_color_cmyk` = $surface_code_cmyk,
    `c_surface_color_rgb` = $surface_code_rgb,
    `c_surface_hex_code` = $surface_hex_code,
    `c_expected_power` = $expected_power,
    `c_client_type` = $client_type,
    `c_client_value` = $client_value,
    `c_tag` = $tag,
    `c_memo` = $memo,
    `c_insert_datetime` = $datetime
";

$result = DB_INSERT( $query );
if( $result ) {
    echo "SUCCESS";
}else {
    echo "FAILED";
}

?>