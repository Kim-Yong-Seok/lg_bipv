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
		<h1>Project</h1>
		<button class="btn btnPrev" type="button" onclick="location.href='./home.php'">이전</button>
	</header>
	<main class="fs0">
		<section>
			<div class="inner type2">
				<div class="inner-item mgt_0">
					<select class="inner_left w30p" id="sort_standard">
						<option value="time">Time</option>
						<option value="color">Color</option>
					</select>
					<div class="inner_right">
						<span class="right_area">
							<button class="btn btnThumbnail active" type="button">썸네일</button>
							<button class="btn btnHorizontal" type="button">가로형</button>
							<button class="btn btnVertical" type="button">세로형</button>
						</span>
					</div>
				</div>
			</div>
			<div class="inner project" id="project">
				
			</div>
		</section>

	</main>
</div>
</body>
</html>
<script type="text/javascript">
    $(window).load(() => {
        $('.btnThumbnail').trigger('click');
    });
    
    $('#sort_standard').change(() => {
        $('.active').trigger('click');
    });

    $('.btnThumbnail').click(() => {
        var standard = $('#sort_standard').val();
        var url = './project/thumbnail';

        $('.active').removeClass('active');
        $('.btnThumbnail').addClass('active');

        if( standard == 'time' ) url += '1.php';
        else url += '2.php';

        $.ajax({
            url: url,
            method: 'get',
            success: ( res ) => {
                $('#project').html( res );
            }
        });

    });

    $('.btnHorizontal').click(() => {
        var standard = $('#sort_standard').val();
        var url = './project/horizontal';

        $('.active').removeClass('active');
        $('.btnHorizontal').addClass('active');

        if( standard == 'time' ) url += '1.php';
        else url += '2.php';

        $.ajax({
            url: url,
            method: 'get',
            success: ( res ) => {
                $('#project').html( res );
            }
        });

    });

    $('.btnVertical').click(() => {
        var standard = $('#sort_standard').val();
        var url = './project/vertical';

        $('.active').removeClass('active');
        $('.btnVertical').addClass('active');

        if( standard == 'time' ) url += '1.php';
        else url += '2.php';

        $.ajax({
            url: url,
            method: 'get',
            success: ( res ) => {
                $('#project').html( res );
            }
        });

    })
</script>