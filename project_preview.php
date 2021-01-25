<?php
session_start();
require_once('./server/config.php');
$id = $_GET['id'];

$query = "SELECT * FROM `b_bipv_color` WHERE `c_no`=$id";
$result = $conn->query( $query );
$res = $result->fetch_array(MYSQLI_ASSOC);


$user_state = $_SESSION['state'];
$effectiveness = false;

if( $user_state == 'L' || $user_state == 'M' ) {
	$effectiveness = true;
}
// $color_type = $res['c_input_color_type'];
// $color_target = $res['c_target'];

// if( $color_target == 'T' ) {
//     $none_fixed_hex_code = $res['c_surface_hex_code'];
//     $fixed_hex_code = $res['c_target_hex_code'];
// } else {
//     $none_fixed_hex_code = $res['c_target_hex_code'];
//     $fixed_hex_code = $res['c_surface_hex_code'];
// }
?>
<!DOCTYPE HTML>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalabel=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>LG전자 BIPV</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="./js/default.js"></script>
</head>
<body>
<div id="wrap">
	<header class="header">
		<h1><?=$res['c_color_name']?></h1>
		<button class="btn btnPrev" type="button" onclick="location.herf='./home.php';">이전</button>
		<?php 
			if( $effectiveness ) {
				?>
				<button class="btn btnEdit" type="button" onclick="location.href='./UpdateColor.php?id=<?=$id?>';">편집</button>
				<?php
			}
		
		?>
	</header>
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Preview</h2>
				<div class="inner-item">
					<div class="col color_left">
						<h3>Target Color</h3>
						<div class="color_code" style="background: <?=$res['c_target_hex_code']?>;"></div>
					</div>
					<div class="col color_right">
						<h3>Surface Color</h3>
						<div class="color_code" style="background: <?=$res['c_surface_hex_code']?>;"></div>
					</div>
				</div>

				<h3 class="sub"><span>Surface<em><?=100-$res['c_pv']?></em></span><span>PV<em><?=$res['c_pv']?></em></span></h3>
				<div class="inner-item">
					<!-- pv0 pv25 pv50 pv75 pv100 -->
					<table class="color_ratio pv25" style="background: <?=$res['c_surface_hex_code']?>;">
						<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td>
						</tr>
						<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td>
						</tr>
						<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td>
						</tr>
						<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td>
						</tr>
						<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
		</section>

		<section>
			<div class="inner type_view">
				<div class="inner-view-item mgt_0">
					<h2>Expected Power</h2>
					<span class="item"><?=$res['c_expected_power']?> kWh</span>
				</div>

				<div class="inner-view-item">
					<h2>Client</h2>
					<span class="item"><?=$res['c_client_type']?></span>
					<span class="item"><?=$res['c_client_value']?></span>
				</div>

				<div class="inner-view-item">
					<h2>Tag</h2>
					<div class="mgt_0">
                        <?php
                            $tag = explode(',', $res['c_tag']);
                            for( $i=0; $i<sizeof($tag); $i++ ) {
                                echo '<span class="tag ellipsis">'.$tag[$i].'</span>';
                            }
                        ?>
					</div>
				</div>
                <?php
                    $date = explode(' ', $res['c_insert_datetime']);
                    $date = str_replace('-', '.', $date[0]);
                ?>
				<div class="inner-view-item">
					<h2>Memo</h2>
					<ul class="ul_list">
						<li><?=$res['c_memo']?> <span class="day"><?=$res['c_memo'] ? $date : ''?></span></li>
					</ul>
				</div>

				<div class="inner-view-item">
					<h2>Environment</h2>
					<ul class="ul_list">
						<?php
							$query = 'SELECT * FROM `b_environment`;';
							$result = $conn->query( $query );
							$res = $result->fetch_array(MYSQLI_ASSOC);
							$glasses = $res['e_glass_type']." ".$res['e_glass_thickness']." ".$res['e_glass_texture'];
							if( $res['e_continent'] == 'Etc' ) {
								$cont = $res['e_country_text']." ";
							} else {
								$cont = $res['e_continent']." ".$res['e_country']." ";
							}

							if( $res['e_illuminant'] == 'Etc' ) {
								$cont .= $res['e_illuminant_text'];
							} else {
								$cont .= $res['e_illuminant'];
							}
						?>
						<li><?=$glasses?></li>
						<li><?=$cont?></li>
					</ul>
				</div>
			</div>
		</section>

	</main>
</div>
</body>
</html>
