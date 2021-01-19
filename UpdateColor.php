<?php
require_once('./server/config.php');

$id = $_GET['id'];

$query = "SELECT * FROM `b_bipv_color` WHERE `c_no`=$id";
$result = $conn->query( $query );
$res = $result->fetch_array(MYSQLI_ASSOC);

$color_type = $res['c_input_color_type'];
$color_target = $res['c_target'];

if( $color_target == 'T' ) {
    $none_fixed_hex_code = $res['c_surface_hex_code'];
    $fixed_hex_code = $res['c_target_hex_code'];
} else {
    $none_fixed_hex_code = $res['c_target_hex_code'];
    $fixed_hex_code = $res['c_surface_hex_code'];
}

?>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalabel=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>LG전자 BIPV</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<!-- <script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="./js/default.js"></script>
<script type="text/javascript" src="./js/convert.js"></script>
<script type="text/javascript" src="./js/color_picker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="./js/lib.js"></script>
</head>
<body>
<div id="wrap">
	<header class="header">
		<h1>Add New Color</h1>
		<button class="btn btnPrev" type="button" onclick="history.back(-1)">이전</button>
    </header>
    <form action="./server/color/add_new_color.php" method="POST" id="addNewColorForm">
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Color Code</h2>
				<div class="right_area">
					<div class="chktype2">
						<div class="chkwrap">
							<input type="checkbox" id="chkAccept1" onchange="selectTarget()" name="target_value" <?=$res['c_target']=='S' ? 'checked': ''?>>
							<label class="switch" for="chkAccept1">
								<span class="slider"></span>
								<span class="tip left">Target</span>
								<span class="tip right">Surface</span>
							</label>
						</div>
					</div>
				</div>
				<div class="inner-item">
					<select style="width: 30%;" id="inputCodeType" onchange="selectCodeType()" name="color_type_value">
                        <option value="lab" <?=$color_type == 'lab' ? 'selected' : ''?>>Lab</option>
                        <option value="rgb" <?=$color_type == 'rgb' ? 'selected' : ''?>>RGB</option>
                        <option value="cmyk" <?=$color_type == 'cmyk' ? 'selected' : ''?>>CMYK</option>
						<option value="pantone" <?=$color_type == 'pantone' ? 'selected' : ''?>>Pantone</option>
                    </select>
                    <!-- rgb 선택일 경우 -->
					<div class="input_box rgb mgl_10 " id="inputCodeBox1" style="width: calc(70% - 10px); <?=$color_type == 'lab' || $color_type == 'rgb' ? 'display: inline-block' : 'display: none'?>">
                        <input type="text" id="ibv1_1" name="ibv1_1" value="<?=$res['c_input_color_code1']?>"> - 
						<input type="text" id="ibv1_2" name="ibv1_2" value="<?=$res['c_input_color_code2']?>"> - 
						<input type="text" id="ibv1_3" name="ibv1_3" value="<?=$res['c_input_color_code3']?>" onfocusout="setColor()">
					</div>
					<!-- CMYK 선택일 경우 -->
					<div class="input_box cmyk mgl_10" id="inputCodeBox2" style="width: calc(70% - 10px); <?=$color_type == 'cmyk' ? 'display: inline-block' : 'display: none'?>">
						<input type="text" id="ibv2_1" name="ibv2_1" value="<?=$res['c_input_color_code1']?>"> - 
						<input type="text" id="ibv2_2" name="ibv2_2" value="<?=$res['c_input_color_code2']?>"> - 
						<input type="text" id="ibv2_3" name="ibv2_3" value="<?=$res['c_input_color_code3']?>"> - 
						<input type="text" id="ibv2_4" name="ibv2_4" value="<?=$res['c_input_color_code4']?>" onfocusout="setColor()">
					</div>
					<div class="input_box pantone mgl_10" id="inputCodeBox3" style="width: calc(70% - 10px); <?=$color_type == 'pantone' ? 'display: inline-block' : 'display: none'?>">
						<input type="text" id="ibv3_1" name="ibv3_1" value="<?=$res['c_input_color_code1']?>"> - 
						<input type="text" id="ibv3_2" name="ibv3_2" value="<?=$res['c_input_color_code2']?>" onfocusout="setColor()">
					</div>
                </div>
				<div class="button_area">
					<button class="btnPhoto"><span>Photo</span></button>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Preview</h2>
				<div class="inner-item">
					<div class="col color_left">
						<h3>Target Color</h3>
						<div class="color_code <?=$color_target == 'T' ? 'fixedTarget' : 'noneFixedTarget'?>" id="targetColor" ></div>
					</div>
					<div class="col color_right">
						<h3>Surface Color</h3>
						<div class="color_code <?=$color_target == 'S' ? 'fixedTarget' : 'noneFixedTarget'?>" id="surfaceColor" ></div>
					</div>
				</div>

				<h2>PV Ratio</h2>
				<div class="inner-item">
					<!-- pv0 pv25 pv50 pv75 pv100 -->
					<table class="color_ratio pv50 noneFixedTarget" id="pvTable">
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

					<div class="ratio_bar">
						<span class="left"><em id="pvSliderValue2">50</em>%</span>
                        <span class="right"><em id="pvSliderValue">50</em>%</span>
                        <input type="hidden" id="pvValue" name="pv_value">
                        <div id="pvSlider"></div>
						<!-- 슬라이드 스크립트 적용 -->
						<span class="tit left" id="targetName">Surface Color</span>
						<span class="tit right">PV</span>
					</div>

					<dl class="openList_area">
						<dt class="active"><a href="#a"><h2>Surface Color Adjustment</h2></a></dt>
						<dd class="openList_item">
							<div class="ratio_bar">
                                <span class="tit2">Brightness</span>
                                <input type="hidden" id="brightnessValue" name="brightness_value">
								<!-- <div class="bar small" style="background: #aa463b;"></div> -->
                                <!-- 슬라이드 스크립트 적용 -->
                                <div id="brightSlider"></div>
							</div>
							<div class="ratio_bar">
                                <span class="tit2">Saturation</span>
                                <input type="hidden" id="saturationValue" name="saturation_value">
								<!-- <div class="bar small" style="background: #aa463b;"></div> -->
                                <!-- 슬라이드 스크립트 적용 -->
                                <div id="toneSlider"></div>
							</div>
							<div class="ratio_bar">
                                <span class="tit2">Hue</span>
                                <input type="hidden" id="hueValue" name="hue_value">
								<!-- <div class="bar small" style="background: #aa463b;"></div> -->
                                <!-- 슬라이드 스크립트 적용 -->
                                <div id="hueSlider"></div>
							</div>
						</dd>
					</dl>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Expected Power</h2>
				<div class="inner-item relative">
					<input class="input_box text-right" type="text" readonly id="expectedPower" name="expected_power">
					<span class="right_area">W</span>
				</div>

				<h2>Client</h2>
				<div class="inner-item">
					<select class="col">
						<option selected>Public</option>
						<option>option</option>
					</select>
					<select class="col">
						<option selected>Company</option>
						<option>option</option>
					</select>
				</div>
				
				<h2>Tag</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Input text">
				</div>

				<h2 class="relative">
					Tag 
					<button class="btn btn_option">옵션</button>
				</h2>
				<div class="inner-item relative">
					<ul class="ul_list">
						<li>Float Tempered Glass 5T</li>
						<li>Asia Korea D65</li>
					</ul>
				</div>
			</div>
		</section>


		<div class="bottom_btn_area">
			<button class="btn typeBlack" type="button" onclick="addNewColor();">SAVE</button>
        </div>
        <input type="hidden" id="fixedHexValue" name="fixed_hex_value">
        <input type="hidden" id="noneFixedHexValue" name="none_fixed_hex_value">
    </main>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    $(window).load(() => {
        var pv = <?php echo $res['c_pv']; ?>;
        var bright = <?php echo $res['c_adjust_brightness']; ?>;
        var tone = <?php echo $res['c_adjust_saturation']; ?>;
        var hue = <?php echo $res['c_adjust_hue']; ?>;
        
        console.log( pv, bright, tone, hue );

        NONE_FIXED_HEX_CODE = '<?php echo $none_fixed_hex_code; ?>';
        FIXED_HEX_CODE = '<?php echo $fixed_hex_code; ?>';
        purposeTarget = '<?php echo $color_target; ?>';

        // setColor();
        changePv( pv );
        changeBright( bright );
        changeTone( tone );
        changeHue( hue );

        $('#pvSlider').slider( 'option', 'value', pv );
        
    })
</script>