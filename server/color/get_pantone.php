<?php

$ch = curl_init();
$color_type = $_GET['color_type'];
$color_code = $_GET['color_code'];
$color_code = urlencode($color_code);

curl_setopt( $ch, CURLOPT_URL, 'https://www.pantone.com/color-finder/'.$color_code );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

$res = curl_exec( $ch );

// RGB
$red = explode('"Red":', $res);
$red = explode(',"', $red[1]);
$red = $red[0];

$green = explode('"Green":', $res);
$green = explode(',"', $green[1]);
$green = $green[0];

$blue = explode('"Blue":', $res);
$blue = explode('}', $blue[1]);
$blue = $blue[0];

// HEX
$hex = explode('"hex":{"HTML":"', $res);
$hex = explode('"}', $hex[1]);
$hex = "#".$hex[0];

// CMYK
$cyan = explode('"Cyan":', $res);
$cyan = explode(',"', $cyan[1]);
$cyan = $cyan[0];

$magenta = explode('"Magenta":', $res);
$magenta = explode(',"', $magenta[1]);
$magenta = $magenta[0];

$yellow = explode('"Yellow":', $res);
$yellow = explode(',"', $yellow[1]);
$yellow = $yellow[0];

$key = explode('"Key":', $res);
$key = explode('},', $key[1]);
$key = $key[0];

// printf("RGB { R: %s, G: %s, B: %s }<br>CMYK { C: %s M: %s Y: %s K: %s }<br>HEX { #%s }", $red, $green, $blue, $cyan, $magenta, $yellow, $key, $hex);

curl_close($ch);

if( $color_type == "rgb" ) {
    $arr = array( 'red' => $red, 'green' => $green, 'blue' => $blue );
    echo json_encode( $arr );
}else if( $color_type == "cmyk" ) {
    $arr = array(
        'cyan' => $cyan,
        'magenta' => $magenta,
        'yellow' => $yellow,
        'key' => $key
    );
    echo json_encode( $arr );
}else if( $color_type == "hex" ) {
    echo json_encode( array( 'hex' => $hex ) );
}
// $arr = array( 'data' => array(
//     'rgb' => array(
//         'red' => $red,
//         'green' => $green,
//         'blue' => $blue
//     ),
//     'cmyk' => array(
//         'cyan' => $cyan,
//         'magenta' => $magenta,
//         'yellow' => $yellow,
//         'key' => $key
//     ),
//     'hex' => $hex
// ) );
// echo json_encode( $arr );


?>