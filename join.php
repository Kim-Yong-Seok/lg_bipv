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
</head>
<body>
<div id="wrap">
	<header class="header">
		<h1>Register</h1>
		<button class="btn btnPrev" type="button" onclick="location.href='./login.php';">이전</button>
	</header>
	<div class="alert" id="alert">
		<div class="popup-content">
			<div class="message">
				
			</div>
		</div>
	</div>
    <form action="./server/login/register.php" method="POST" id="form">
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Name</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Input Full Name" name="name" id="name">
				</div>

				<h2>Email Address</h2>
				<div class="inner-item">
					<input class="input_box" type="text" placeholder="Company Email Only" name="email" id="email">
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
		var name = $('#name').val();
		var email = $('#email').val();
        var password = $('#password').val();
		var repassword = $('#repassword').val();
		var formData = $('#form').serialize();

		if( !name ) {
			showAlert('Please enter name');
			return;
		}

		if( !email ) {
			showAlert('Please enter email address');
			return;
		} else if( !email.includes('@lge.com') ) {
			showAlert('Please enter <br>right email address');
			return;
		}

		if( password.length < 8 ) {
			showAlert('Please enter more than 7 characters');
			return;
		} else if ( password.length > 12 ) {
			showAlert('Please enter less than 13 characters');
		} else {
			var english = /^[a-zA-Z0-9]+$/;
			var index = password.length;
			var flag = false;

			while( --index ) {
				if( !english.test( password[index] ) ) {
					flag = true;
				}
			}
			if( flag ) {
				showAlert('Please enter password <br>using both letters and numbers');
				return;
			}
		}

        if( password != repassword ) {
			showAlert('Password do not matches');
            return;
        }
		
		$.ajax({
			url: './server/login/register.php',
			method: 'post',
			data: formData,
			success: ( res ) => {
				if( res == 1 ) {
					showAlert('Successfully registered');
					setTimeout(() => {
						location.href='./login.php';
					}, 2300);
				}else {
					showAlert('Same email address exist');
				}
			}
		})
    }
</script>
