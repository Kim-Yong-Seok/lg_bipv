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
		<button class="btn btnPrev" type="button" onclick="location.href='./home.php';">이전</button>
	</header>
	<div class="alert" id="alert">
		<div class="popup-content">
			<div class="message">
				권한을 수정하였습니다.
			</div>
		</div>
	</div>
	<main class="fs0 bgGray">
		<section>
			<div class="inner">
				<h2>Pattern</h2>
				<div class="inner-item">
					<div class="input_box icoSearch">
						<input type="text" placeholder="이름을 입력해주세요." onfocusout="setName();" id="name" name="name">
					</div>
					<!-- <input class="input_box" type="text" placeholder="이름을 입력해주세요."> -->
				</div>
			</div>
		</section>

		<section>
			<div class="inner">
				<h2>Search by list</h2>
				<div class="inner-item">
					<select id="approveList" name="approveList" onchange="changeApproveList()">
						<option value="N">Waiting Approved</option>
						<option value="Y">Approved</option>
					</select>
				</div>
				<div class="inner-item">
					<select id="userList" name="userList" onchange="selectUser();">
						<option value="">-</option>
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
						<dd class="default" id="ID"></dd>
					</dl>
					<input type="hidden" id="idValue" name="id">
					<dl class="inner-list">
						<dt>Name</dt>
						<!-- 검색 후 : default 삭제 -->
						<dd class="default" id="userName"></dd>
					</dl>
				</div>
				<div class="inner-item">
					<h3>Authority</h3>
					<select disabled id="authority" name="authority">
						<option value="L">Leader</option>
						<option value="M">Member</option>
						<option value="R">Relation</option>
					</select>
				</div>
			</div>
		</section>

		<div class="bottom_btn_area col2">
			<button class="btn typeWhite" type="button" onclick="location.href='./home.php';">CANCEL</button>
			<button class="btn typeWhite" type="button" onclick="submit();">OK</button>
		</div>

	</main>
</div>
</body>
</html>
<script type="text/javascript">

	$(window).load(() => {
		changeApproveList();
	});

	function showAlert() {
		if($('#wrap').find('.bottom_btn_area')){
			$('.alert').css('bottom', '68px');
		}; 

		$('#alert').fadeIn(300);

		setTimeout(function() {
			$('#alert').fadeOut(300);
		}, 2000);
	}

	function submit() {
		var id = $('#idValue').val();
		var authority = $('#authority').val();
		
		$.ajax({
			url: './server/setting/authority_setting.php',
			method: 'post',
			data: {
				u_email: id,
				u_authority: authority
			},
			success: ( res ) => {
				if( res ) {
					showAlert();
				}
			}
		})
	}

	function selectUser() {
		var name = $('#userList').val();

		if( name ) {
			$.ajax({
				url: './server/setting/find_user.php',
				method: 'post',
				data: {
					name: name
				},
				success: ( res ) => {
					if( res ) setUser( res );
				}
			});
		} else {
			$('#userName').addClass('default');
			$('#ID').addClass('default');
			$('#authority').attr('disabled', 'disabled');

			$('#ID').html('');
			$('#userName').html('');
			$('#authority').val('L');
		}
		
	}

	function changeApproveList() {
		var listValue = $('#approveList').val();

		$.ajax({
			url: './server/setting/find_approved.php',
			method: 'post',
			data: {
				effectiveness: listValue
			},
			success: ( res ) => {
				if( res ) {
					$('#userList').html('<option value="">-</option>');
					var obj = JSON.parse( res );
					for(var i=0; i<obj.length; i++) {
						var state = '';
						switch( obj[i].u_state ) {
							case 'R':
								state = 'Relation';
								break;
							case 'L':
								state = 'Leader';
								break;
							case 'M':
								state = 'Member';
								break;
							default:
								break;
						} 
						var str = '<option value="'+obj[i].u_name+'">'+obj[i].u_name+'('+state+')'+'</option>';
						$('#userList').append( str );
					}
				} else {
					$('#userList').html('<option value="">-</option>');
				}
			}
		})
	}

	function setUser( res ) {
		var obj = JSON.parse( res );
		var user_name = obj.u_name;
		var user_email = obj.u_email;
		var authority = obj.u_state;
		
		$('#userName').removeClass();
		$('#ID').removeClass();
		$('#authority').removeAttr('disabled');

		$('#ID').html(user_email);
		$('#userName').html(user_name);
		$('#authority').val(authority);

		$('#idValue').val(user_email);
	}

	function setName() {
		var name = $('#name').val();
		$.ajax({
			url: './server/setting/find_user.php',
			method: 'post',
			data: {
				name: name
			},
			success: ( res ) => {
				if( res ) setUser( res );
			}
		})
	}
</script>