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
		<h1>Register</h1>
		<button class="btn btnPrev" type="button">이전</button>
    </header>
    <form action="./server/login/register.php" method="POST" id="form">
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Name</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Input Full Name" name="name">
				</div>

				<h2>Email Address</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Company Email Only" name="email">
				</div>

				<h2>Password</h2>
				<div class="inner-item">
					<input class="input_box" type="password" placeholder="●●●●●●●●●●" name="password" id="password">
				</div>

				<h2>Confirm Password</h2>
				<div class="inner-item">
					<input class="input_box" type="password" placeholder="●●●●●●●●●●" id="repassword">
				</div>
			</div>
        </section>

		<div class="bottom_btn_area">
			<button class="btn typeWhite" type="button" onclick="check();">SAVE</button>
		</div>

    </main>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    function check() {
        var password = $('#password').val();
        var repassword = $('#repassword').val();

        if( password != repassword ) {
            alert('패스워드가 일치하지 않습니다.');
            return;
        }
        
        $('#form').submit();
    }
</script>
