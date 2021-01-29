<?php
session_start();
require_once('./server/config.php');
if( !$_SESSION['no'] ) {
	alert('로그인을 다시 해주세요.');
	go_to('login.php');
}
$user_no = $_SESSION['no'];
$user_name = $_SESSION['name'];
$user_state = $_SESSION['state'];

?>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalabel=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>LG전자 BIPV</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="./js/index.js"></script>
</head>
<body>
<div id="wrap" class="home">
	<div class="left_menu">
		<div class="dimmed"></div>
		<nav>
			<div class="profile">
				<dl>
					<dt>My Info</dt>
					<dd><?=$user_name?></dd>
				</dl>
			</div>
			<div class="menu">
				<ul>
					<li><a href="./server/login/logout.php">Log out</a></li>
					<?php
						if( $user_state == 'L' ) {
							?>
							<li><a href="environment.php">Environment Setting</a></li>
							<li><a href="authority.php">Authority Setting</a></li>
							<?php
						}
					?>
				</ul>
			</div>
			<button class="btn close" type="button">닫기</button>
		</nav>
	</div>

	<header class="header">
		<button class="btn btnMenu" type="button">이전</button>
		<?php
			if( $user_state == "L" || $user_state == "M" ) {
		?>
			<button class="btn btnAddNew" type="button" onclick="location.href='./AddNewColor.php';">추가</button>
		<?php
			}
		?>
		<h1><img src="./images/img_logo.png" alt="LG BIPV AC Color DX"></h1>
	</header>
	<main class="fs0 bgGray relative">

		<div class="tap_area">
			<div class="chkwrap">
				<input type="checkbox" id="chkAccept1" checked onchange="showMyWork(<?=$user_no?>);">
				<label class="switch" for="chkAccept1">
					<span class="slider"></span>
					<span class="tip left">My Work</span>
					<span class="tip right">All</span>
				</label>
			</div>
		</div>

		<section>
			<?php
				$query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='N' ORDER BY `c_no` DESC";
				$result = $conn->query( $query );
			?>
			<div class="inner">
				<h2 class="relative">
					Project
					<span class="num"><?=$result->num_rows?></span>
					<button class="btn btn_more" onclick="location.href='./profile_list.php';">더보기</button>
				</h2>
				<?php
					if( $result->num_rows > 0 ) {
						?>
						<div class="inner-item">
							<?php
								while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
									
									if( $res['c_user_no'] != $user_no ) $my_works = 'not_my_color_works';
									else $my_works = '';

									?>
									<dl class="color_list <?=$my_works?>" onclick="location.href='./project_preview.php?id=<?=$res['c_no']?>'">
										<dd style="background: <?=$res['c_target_hex_code']?>;"></dd>
										<dt><?=$res['c_color_name']?></dt>
									</dl>
									<?php							
								}
							?>
						</div>
						<?php
					} else {
						?>
						<div class="inner-item">
							<p class="nodata">Please add a project.</p>
						</div>
						<?php
					}
				?>
			</div>
		</section>

		<section>
			<?php
				$query = "SELECT * FROM `b_bipv_color` WHERE `c_approval`='Y' ORDER BY `c_no` DESC;";
				$result = $conn->query( $query );
			?>
			<div class="inner">
				<h2 class="relative">
					Library
					<span class="num"><?=$result->num_rows?></span>
					<button class="btn btn_more" onclick="location.href='./library_list.php';">더보기</button>
				</h2>
				<div class="inner-item scroll_x">
					<?php
						if( $result->num_rows > 0 ) {
							?>
							<div class="inner_scroll" style="width: 400px;">
								<?php
									while( $res = $result->fetch_array(MYSQLI_ASSOC) ) {
										?>
										<dl class="color_list library">
											<dd style="background: <?=$res['c_surface_hex_code']?>;">
												<ul>
													<li class="left" style="background: <?=$res['c_target_hex_code']?>;"></li>
													<li class="right" style="background: #000000;"></li>
												</ul>
											</dd>
											<dt><?=$res['c_color_name']?></dt>
											<span class="tag ellipsis">#Tagtag</span>
										</dl>
										<?php
									}
								?>
							</div>
							<?php
						} else {
							?>
							<p class="nodata">Please add a library.</p>
							<?php
						}
					?>
					<!-- 100 * 4 -->
					
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2 class="relative">
					Cluster
					<button class="btn btn_more">더보기</button>
				</h2>
				<div class="inner-item">
					<input class="input_box search" type="text" placeholder="Search for Color or Tag Name">
					<div class="tag_area">
						<div class="color_tag"><em class="dot" style="background: #66476a;"></em><span class="text ellipsis">#현대건설</span></div>
						<div class="color_tag"><em class="dot" style="background: #50778f;"></em><span class="text ellipsis">#레미안</span></div>
						<div class="color_tag"><em class="dot" style="background: #94946c;"></em><span class="text ellipsis">#서울시범사업</span></div>
					</div>
				</div>
			</div>
		</section>
	</main>
</div>
</body>
</html>
<script type="text/javascript">
	function showMyWork( no ) {
		$('.not_my_color_works').toggle();
	}
</script>