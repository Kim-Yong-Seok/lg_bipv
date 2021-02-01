<?php
session_start();
require_once('./server/config.php');
$user_no = $_SESSION['no'];
?>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalabel=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>LG전자 BIPV</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="./js/index.js"></script>
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
		<button class="btn btnPrev" type="button" onclick="location.href='./home.php';">이전</button>
    </header>
	<form id="addNewColorForm">
	<div class="dimmed"></div>
	<div class="popup" id="addnewcolorbtn">
		<div class="popup-content">
			<div class="title">Save as</div>
			<div class="message">
				<input class="input_box" type="text" placeholder="프로젝트 명을 입력해주세요." name="pjt_name" id="pjtName">
			</div>
		</div>
		<div class="popup-footer col">
			<button class="btn popup_btn colorGray pop_close" type="button">CANCEL</button>
			<button class="btn popup_btn" onclick="addNewColor()" type="button">OK</button>
		</div>
	</div>
	<button class="alertopen" style="display: none;" type="button"></button>
	<div class="alert" id="alert">
		<div class="popup-content">
			<div class="message">
				
			</div>
		</div>
	</div>
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Color Code</h2>
				<div class="right_area">
					<div class="chktype2">
						<div class="chkwrap">
							<input type="checkbox" id="chkAccept1" onchange="selectTarget()" name="target_value">
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
                        <option value="lab" selected>Lab</option>
                        <option value="rgb">RGB</option>
                        <option value="cmyk">CMYK</option>
						<option value="pantone">Pantone</option>
					</select>
					<!-- rgb 선택일 경우 -->
					<div class="input_box rgb mgl_10 " id="inputCodeBox1" style="width: calc(70% - 10px);">
						<input type="text" id="ibv1_1" name="ibv1_1"> - 
						<input type="text" id="ibv1_2" name="ibv1_2"> - 
						<input type="text" id="ibv1_3" name="ibv1_3" onfocusout="setColor()">
					</div>
					<!-- CMYK 선택일 경우 -->
					<div class="input_box cmyk mgl_10" id="inputCodeBox2" style="width: calc(70% - 10px); display: none;">
						<input type="text" id="ibv2_1" name="ibv2_1"> - 
						<input type="text" id="ibv2_2" name="ibv2_2"> - 
						<input type="text" id="ibv2_3" name="ibv2_3"> - 
						<input type="text" id="ibv2_4" name="ibv2_4" onfocusout="setColor()">
					</div>
					<div class="input_box pantone mgl_10" id="inputCodeBox3" style="width: calc(70% - 10px); display: none;">
						<input type="text" id="ibv3_1" name="ibv3_1"> - 
						<input type="text" id="ibv3_2" name="ibv3_2" onfocusout="setColor()">
					</div>
                </div>
                <!-- <input type="hidden" name="color_value_1" id="colorValue1">
                <input type="hidden" name="color_value_2" id="colorValue2">
                <input type="hidden" name="color_value_3" id="colorValue3"> -->
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
						<div class="color_code fixedTarget" id="targetColor" style="text-align: center;">
							<p style="font-size: 16px; float: left; width: 100%;"></p>
						</div>
					</div>
					<div class="col color_right">
						<h3>Surface Color</h3>
						<div class="color_code noneFixedTarget" id="surfaceColor" style="text-align: center;">
							<p style="font-size: 16px; float: left; width: 100%;"></p>
						</div>
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
					<select class="col" name="client_type">
						<option selected>None</option>
						<option value="Public">Public</option>
						<option value="Company">Company</option>
					</select>
					<select class="col" name="client_value">
						<option class="public_item" value="Seoul City">Seoul city</option>
						<option class="public_item" value="LH">LH</option>
						<option class="public_item" value="SH">SH</option>
						<option class="company_item" value="Hyundai">Hyundai</option>
						<option class="company_item" value="Xi">Xi</option>
						<option class="company_item" value="Ramian">Ramian</option>
						<option value="etc">Etc-추가입력</option>
					</select>
				</div>
				
				<h2>Tag</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Input text" name="tag">
				</div>

				<h2>Memo</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Input text" name="memo">
				</div>

				<h2 class="relative">
					Environment
					<button class="btn btn_option" type="button" onclick="location.href='./environment.php';">옵션</button>
				</h2>
				<div class="inner-item relative">
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


		<div class="bottom_btn_area">
			<button class="btn typeWhite popopen" type="button" onclick="setName();" name="addnewcolorbtn">SAVE</button>
		</div>
		
        <input type="hidden" id="fixedHexValue" name="fixed_hex_value">
        <input type="hidden" id="noneFixedHexValue" name="none_fixed_hex_value">
    </main>
    </form>
</div>
</body>
</html>
