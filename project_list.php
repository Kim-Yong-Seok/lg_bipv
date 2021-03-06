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
<script type="text/javascript" src="./js/convert.js"></script>
</head>
<body>
<div id="wrap">
	<header class="header">
		<h1>Project</h1>
        <button class="btn btnPrev" type="button" onclick="location.href='./home.php'">이전</button>
        <button class="btn btnCompare" type="button" style="display: none;" onclick="compareSelect();">비교</button>
		<button class="btn btnDelete" type="button" style="display: none;" onclick="deleteSelect();">삭제</button>
    </header>
    <form id="form" method="post">
	<main class="fs0">
		<section>
			<div class="inner type2">
				<div class="inner-item mgt_0">
					<select class="inner_left w30p" id="sort_standard">
						<option value="time">Time</option>
						<option value="color">Color</option>
					</select>
					<div class="inner_right">
                        <input type="checkbox" style="display: none;" id="selectCheckbox" />
						<span class="right_area">
                            <button class="btn btnProjectCheck" type="button" onclick="selectOpen()" id="projectCheck">체크표시</button>
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
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    var cnt = 0;
    $(window).load(() => {
        $('.btnThumbnail').trigger('click');
        $('#sort_standard').val('time');
        
    });
    
    $('#sort_standard').change(() => {
        $('.active').trigger('click');
    });

    function compareSelect() {
        $('#form').attr('action', './project_compare.php');
        $('#form').submit();
    }

    function deleteSelect() {
        $.ajax({
            url: './server/color/delete_project.php',
            method: 'post',
            data: $('#form').serialize(),
            success: ( res ) => {
                console.log( res );
            }
        });
        location.reload();
    }

    function showHeaderButton() {
        if( cnt % 2 ) {
            $('.btnDelete, .btnCompare').show();
        } else {
            $('.btnDelete, .btnCompare').hide();
        }
    }
    
    function selectOpen() {
        cnt++;
        $('.chkwrap').toggle();
        $('.check').toggle();
        if( $('#projectCheck').hasClass('checked') ) {
            $('#projectCheck').removeClass('checked');
        }else {
            $('#projectCheck').addClass('checked');
        }
        showHeaderButton();

        var linkValue = $('.lists').attr('onclick');

        if($('.chkwrap').is(':visible')) {
            $('.lists').attr('onclick', '/*'+linkValue + '*/');
        } else {
            linkValue = linkValue.replace('/*', '');
            linkValue = linkValue.replace('*/', '');
            
            $('.lists').attr('onclick', linkValue);
        }
    }

    $('.btnThumbnail').click(() => {
        cnt = 0;
        $('#projectCheck').removeClass('checked');
        showHeaderButton();
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
                colorChipSize();
            }
        });
    });

    $('.btnHorizontal').click(() => {
        cnt = 0;
        $('#projectCheck').removeClass('checked');
        showHeaderButton();
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
        cnt = 0;
        $('#projectCheck').removeClass('checked');
        showHeaderButton();
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
                var i = 1;
                while( $('#vertical_target'+i).length > 0 ) {
                    var hex = $('#vertical_target'+i).attr('name');
                    var rgb = hexToRgb(hex);

                    $('#t_lab'+i).html("Lab " + rgbTolab(rgb).replaceAll(',', ''));
                    $('#t_cmyk'+i).html("CMYK " + rgbToCmyk(rgb).replaceAll(',', ''));
                    $('#t_rgb'+i).html("RGB " + rgb.replaceAll(',', ''));

                    hex = $('#vertical_surface'+i).attr('name');
                    $('#s_lab'+i).html("Lab " + rgbTolab(rgb).replaceAll(',', ''));
                    $('#s_cmyk'+i).html("CMYK " + rgbToCmyk(rgb).replaceAll(',', ''));
                    $('#s_rgb'+i).html("RGB " + rgb.replaceAll(',', ''));
                    i++;
                }
            }
        });

    })
</script>