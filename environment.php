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
		<h1>Environment Setting</h1>
		<button class="btn btnPrev" type="button">이전</button>
	</header>
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Glass</h2>
				<div class="inner-item">
					<div class="inner_left">
						<h3>Glass type</h3>
						<select>
							<option selected>Float Tempered</option>
							<option>option</option>
						</select>
					</div>
					<div class="inner_right">
						<h3>Thickness</h3>
						<select>
							<option selected>5T</option>
							<option>option</option>
						</select>
					</div>
				</div>
				<div class="inner-item">
					<div class="inner_left">
						<h3>Texture</h3>
						<select>
							<option selected>Semi-gloss</option>
							<option>option</option>
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
						<select>
							<option selected>Ceramic</option>
							<option>option</option>
						</select>
					</div>
					<div class="inner_right">
						<select>
							<option selected>Silk</option>
							<option>option</option>
						</select>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Pattern</h2>
				<div class="inner-item">
					<select>
						<option selected>Geometric</option>
						<option>option</option>
					</select>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Country</h2>
				<div class="inner-item">
					<div class="inner_left w30p">
						<select>
							<option selected>Ceramic</option>
							<option>option</option>
						</select>
					</div>
					<div class="inner_right w70p">
						<select>
							<option selected>Silk</option>
							<option>option</option>
						</select>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Illuminant</h2>
				<div class="inner-item">
					<select>
						<option selected>65D</option>
						<option>option</option>
					</select>
				</div>
				<!-- 직접입력시 -->
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Enter directly">
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Distance to BIPV</h2>
				<div class="inner-item">
					<select>
						<option selected>3M</option>
						<option>option</option>
					</select>
				</div>
			</div>
		</section>

		<div class="bottom_btn_area col2">
			<button class="btn typeWhite" type="button">RESET</button>
			<button class="btn typeWhite" type="button">SAVE</button>
		</div>

	</main>
</div>
</body>
</html>
