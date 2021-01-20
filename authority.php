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
		<h1>Authority Setting</h1>
		<button class="btn btnPrev" type="button">이전</button>
	</header>
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Pattern</h2>
				<div class="inner-item">
					<div class="input_box icoSearch">
						<input type="text" placeholder="이름을 입력해주세요.">
					</div>
					<!-- <input class="input_box" type="text" placeholder="이름을 입력해주세요."> -->
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Search by list</h2>
				<div class="inner-item">
					<select>
						<option selected>Select</option>
						<option>option</option>
					</select>
				</div>
				<div class="inner-item">
					<select>
						<option selected>-</option>
						<option>option</option>
					</select>
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<div class="inner-item">
					<dl class="inner-list">
						<dt>ID</dt>
						<!-- 검색 전 : default -->
						<dd class="default">ID</dd>
					</dl>
					<dl class="inner-list">
						<dt>Name</dt>
						<!-- 검색 후 : default 삭제 -->
						<dd>Name</dd>
					</dl>
				</div>
				<div class="inner-item">
					<h3>Authority</h3>
					<select disabled>
						<option selected>65D</option>
						<option>option</option>
					</select>
				</div>
			</div>
		</section>

		<div class="bottom_btn_area col2">
			<button class="btn typeWhite" type="button">CANCEL</button>
			<button class="btn typeWhite" type="button">OK</button>
		</div>

	</main>
</div>
</body>
</html>
