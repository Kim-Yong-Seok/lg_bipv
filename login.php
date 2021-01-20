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
<div id="wrap" class="login">
    <form action="./server/login/login.php" method="POST" id="form">
	<main class="fs0">
        <div class="logo">LG BIPV AC Color DX</div>
		<section>
			<div class="inner">
				<h2>Email Address</h2>
				<div class="inner-item">
					<input type="text" class="input_box" placeholder="Company Email Only" name="email" id="email">
				</div>

				<h2>Password</h2>
				<div class="inner-item">
					<input type="password" class="input_box" placeholder="●●●●●●●●●●" name="password" id="password">
				</div>

				<div class="chkwrap checkBox">
					<input type="checkbox" id="RememberMe" checked>
					<label for="RememberMe" class="text">
						Remember me
					</label>
				</div>

				<p><a href="#">Forgot ID / Password?</a></p>
			</div>
		</section>
		<div class="bottom_btn_area fixed">
			<button class="btn typeBlack" type="button" onclick="location.href='./join.php';">REGISTER</button>
			<button class="btn typeBlack" type="button" onclick="check()">Login</button>
		</div>
    </main>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    function check() {
        if( $('#email').val() && $('#password').val() ) $('#form').submit();
        else {
            alert('이메일 혹은 패스워드를 입력해주세요.');
            return;
        }
    }
</script>