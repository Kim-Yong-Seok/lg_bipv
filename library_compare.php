<!DOCTYPE HTML>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalabel=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>LG전자 BIPV</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="./js/index.js"></script>
<script type="text/javascript" src="./js/convert.js"></script>
</head>
<body>
<div id="wrap">
	<header class="header"> 
		<h1>Compare Colors</h1>
		<button class="btn btnPrev" type="button" onclick="location.href='./project_list.php'">이전</button>
	</header>
	<main class="fs0">
		<section>
			<div class="inner project">
				<div class="inner-item">
					<ul class="list-vertical">

                        <?php
                            require_once('./server/config.php');

                            $query = "SELECT * FROM `b_bipv_color` WHERE `c_approval` = 'Y';";
                            $result = $conn->query( $query );
                            $i = 1;
                            if( isset($result) && $result->num_rows > 0 ) {
                                while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
                                    $chk_sum = 'check_'.$res['c_no'];
                                    $no = $res['c_no'];
                                    
                                    if( isset($_POST[$chk_sum]) ) {
                                        ?>
                                        <li>
                                            <div class="title"><?=$res['c_color_name']?></div>
                                            <table class="color_ratio pv<?=$res['c_pv']?>" style="background: <?=$res['c_surface_hex_code']?>;">
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
                                            <dl class="color_area">
                                                <dd class="color_box" style="background: <?=$res['c_target_hex_code']?>;" id="vertical_target<?=$i?>" name="<?=$res['c_target_hex_code']?>"></dd>
                                                <dt class="ellipsis">Target Color</dt>
                                                <dd class="info_box">
                                                    <p id="t_lab<?=$i?>"></p>
                                                    <p id="t_cmyk<?=$i?>"></p>
                                                    <p id="t_rgb<?=$i?>"></p>
                                                </dd>
                                            </dl>
                                            <!-- <div style="width: 60%; display: inline-block;"> -->
                                            <dl class="color_area">
                                                <dd class="color_box" style="background: <?=$res['c_surface_hex_code']?>;" id="vertical_surface<?=$i?>" name="<?=$res['c_surface_hex_code']?>"></dd>
                                                <dt class="ellipsis">Print Color</dt>
                                                <dd class="info_box">
                                                    <p id="s_lab<?=$i?>"></p>
                                                    <p id="s_cmyk<?=$i?>"></p>
                                                    <p id="s_rgb<?=$i?>"></p>
                                                </dd>
                                            </dl>
                                            <dl class="pv_area">
                                                <dd class="color_box" style="background: #000;"></dd>
                                                <dt class="ellipsis">PV</dt>
                                                <dd class="info_box">
                                                    <p>Ratio <?=$res['c_pv']?>%</p>
                                                </dd>
                                            </dl>
                                            <!-- </div> -->
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
                        ?>
					</ul>
				</div>
			</div>
		</section>

	</main>
</div>
</body>
</html>
<script type="text/javascript">
    $(window).load(() => {
        var i = 1;
        while( $('#vertical_target'+i).length > 0 ) {
            var hex = $('#vertical_target'+i).attr('name');
            var rgb = hexToRgb(hex);

            $('#t_lab'+i).html("Lab " + rgbTolab(rgb).replaceAll(',', ''));
            $('#t_cmyk'+i).html("CMYK " + rgbToCmyk(rgb).replaceAll(',', ''));
            $('#t_rgb'+i).html("RGB " + rgb.replaceAll(',', ''));

            hex = $('#vertical_surface'+i).attr('name');
            rgb = hexToRgb(hex);
            $('#s_lab'+i).html("Lab " + rgbTolab(rgb).replaceAll(',', ''));
            $('#s_cmyk'+i).html("CMYK " + rgbToCmyk(rgb).replaceAll(',', ''));
            $('#s_rgb'+i).html("RGB " + rgb.replaceAll(',', ''));
            i++;
        }
    })
</script>