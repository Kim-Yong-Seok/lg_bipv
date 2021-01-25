<?php
session_start();
require_once('./server/config.php');

$user_no = $_SESSION['no'];

$query = "SELECT * FROM `b_environment`";
$result = $conn->query( $query );
$res = $result->fetch_array(MYSQLI_ASSOC);

$e_glass_type = $res['e_glass_type'];
$e_glass_texture = $res['e_glass_texture'];
$e_glass_thickness = $res['e_glass_thickness'];
$e_printing_type1 = $res['e_printing_type1'];
$e_printing_type1_text = $res['e_printing_type1_text'];
$e_printing_type2 = $res['e_printing_type2'];
$e_pattern = $res['e_pattern'];
$e_continent = $res['e_continent'];
$e_country = $res['e_country'];
$e_country_text = $res['e_country_text'];
$e_illuminant = $res['e_illuminant'];
$e_illuminant_text = $res['e_illuminant_text'];
$e_distance = $res['e_distance'];

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
<script type="text/javascript" src="./js/environment.js"></script>
</head>
<body>
<div id="wrap">
	<header class="header">
		<h1>Environment Setting</h1>
		<button class="btn btnPrev" type="button" onclick="location.href='./home.php';">이전</button>
	</header>
	<form action="./server/setting/environment_setting.php" method="POST" id="form">
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Glass</h2>
				<div class="inner-item">
					<div class="inner_left">
						<h3>Glass type</h3>
						<select name="glass_type" id="eGlassType">
							<option value="Float Tempered">Float Tempered</option>
							<option value="Colored">Colored</option>
							<option value="Etching">Etching</option>
						</select>
					</div>
					<div class="inner_right">
						<h3>Thickness</h3>
						<select name="thickness" id="eGlassThickness">
							<option value="5T">5T</option>
							<option value="6T">6T</option>
						</select>
					</div>
				</div>
				<div class="inner-item">
					<div class="inner_left">
						<h3>Texture</h3>
						<select name="texture" id="eGlassTexture">
							<option value="Semi-gloss">Semi-gloss</option>
							<option value="Gloss">Gloss</option>
							<option value="Matt">Matt</option>
						</select>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Printing</h2>
				<div class="inner-item">
					<div class="inner_left">
						<select name="printing_type" onchange="showTextInput('ePrintingType1')" id='ePrintingType1'>
							<option value="Ceramic">Ceramic</option>
							<option value="Etc">Etc</option>
						</select>
					</div>
					<div class="inner_right">
						<select name="printing_value" id="ePrintingType2">
							<option value="Silk">Silk</option>
							<option value="Digital Print">Digital Print</option>
						</select>
					</div>
					<div class="inner-item" style="display: <?=$e_printing_type1=='Etc' ? 'block' : 'none';?>" id="ePrintingType1_input">
						<input class="input_box" type="text" placeholder="Enter directly" name="printing_text">
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Pattern</h2>
				<div class="inner-item">
					<select name="pattern" id="ePattern">
						<option value="Geometric">Geometric</option>
						<option value="Natural">Natural</option>
						<option value="Photo">Photo</option>
					</select>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Country</h2>
				<div class="inner-item">
					<div class="inner_left w30p">
						<select name="continent" onchange="showTextInput('eContinent')" id="eContinent">
							<option value="Asia">Asia</option>
							<option value="Africa">Africa</option>
							<option value="Europe">Europe</option>
							<option value="America">America</option>
							<option value="Oceania">Oceania</option>
							<option value="Etc">Etc</option>
						</select>
					</div>
					<div class="inner_right w70p">
						<select name="country" id="eCountry">
							<option value="Republic of Korea">Republic of Korea</option>
							<option value="People's Republic of China">People's Republic of China</option>
						</select>
					</div>
					<div class="inner-item" style="display: <?=$e_country=='Etc' ? 'block' : 'none';?>;" id="eContinent_input">
						<input class="input_box" type="text" placeholder="Enter directly" name="country_text">
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Illuminant</h2>
				<div class="inner-item">
					<select name="illuminant" onchange="showTextInput('eIlluminant');" id="eIlluminant">
						<option value="65D">65D</option>
						<option value="Etc">Etc</option>
					</select>
				</div>
				<!-- 직접입력시 -->
				<div class="inner-item" style="display: <?=$e_illuminant=='Etc' ? 'block' : 'none';?>;" id="eIlluminant_input">
					<input class="input_box" type="text" placeholder="Enter directly" name="illuminant_text">
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Distance to BIPV</h2>
				<div class="inner-item">
					<select name="distance" name="eDistance">
						<option value="3M">3M</option>
					</select>
				</div>
			</div>
		</section>

		<div class="bottom_btn_area col2">
			<button class="btn typeWhite" type="button" onclick="reset();">RESET</button>
			<button class="btn typeWhite" type="button" onclick="save();">SAVE</button>
		</div>

	</main>
	</form>
</div>
</body>
</html>
<script type="text/javascript">
	$(window).load(() => {
		var glass_type = '<?php echo $e_glass_type; ?>';
		var glass_texture = '<?php echo $e_glass_texture; ?>';
		var glass_thickness = '<?php echo $e_glass_thickness; ?>';
		var printing_type1 = '<?php echo $e_printing_type1; ?>';
		var printing_type1_text= '<?php echo $e_printing_type1_text; ?>';
		var printing_type2 = '<?php echo $e_printing_type2; ?>';
		var pattern = '<?php echo $e_pattern; ?>';
		var continent = '<?php echo $e_continent; ?>';
		var country = '<?php echo $e_country; ?>';
		var country_text = '<?php echo $e_country_text; ?>';
		var illuminant = '<?php echo $e_illuminant; ?>';
		var illuminant_text = '<?php echo $e_illuminant_text; ?>';
		var distance = '<?php echo $e_distance; ?>';

		$('#eGlassType').val( glass_type );
		$('#eGlassTexture').val( glass_texture );
		$('#eGlassThickness').val( glass_thickness );
		$('#ePrintingType1').val( printing_type1 );
		$('#ePrintingType1_input > input').val( printing_type1_text );
		$('#ePrintingType2').val( printing_type2 );
		$('#ePattern').val( pattern );
		$('#eContinent').val( continent );
		$('#eCountry').val( country );
		$('#eContinent_input > input').val( country_text );
		$('#eIlluminant').val( illuminant );
		$('#eIlluminant_input > input').val( illuminant_text );
		$('#eDistance').val( distance );

	});
</script>
