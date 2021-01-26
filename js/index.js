$(function(){ // Load
	openList();
	bottomBtnArea();
	leftNav();
	popopen();
	projectOpenList();
});

function openList(){
	$('.openList_area dt a').click(function(){
		$(this).parent().toggleClass('active').siblings().removeClass('active');
	});
}

function projectOpenList(){
	$('.project .tit a').click(function(){
		console.log("!!!!");
		$(this).parent().toggleClass('active');
		$(this).parent().siblings('ul').toggleClass('active');
	});
}

function bottomBtnArea(){
	var winH = $(window).height() - 60,
		mainH = $('main').height();
	if(mainH <= winH){
		// $('.bottom_btn_area').addClass('fixed');
 	};
}

function leftNav(){
	$('.btnMenu').click(function(){
		$('.left_menu nav').animate({left: '0px'});
		$('.left_menu').addClass('active');
		$('.dimmed').addClass('on');
	});

	$('.left_menu .close').click(function(){

		$('.left_menu nav').animate({left: '-290px'});
		setTimeout(function(){
			$('.left_menu').removeClass('active');
			$('.dimmed').removeClass('on');
		},300);
	});
}

function showAlert( msg ){
    if($('#wrap').find('.bottom_btn_area')){
        $('.alert').css('bottom', '68px');
        $('.message').html( msg );
    };

    $('#alert').fadeIn(300);

    setTimeout(function() {
        $('#alert').fadeOut(300);
    }, 2000);
}

function popopen(){
	$('.popopen').click(function(){
		var Thisname = $(this).attr('name');
		$('#'+Thisname).addClass('on');
		$('.dimmed').addClass('on');
	});
	
	$('.pop_close').click(function(){
		$('.dimmed').removeClass('on');
		$('.popup').removeClass('on');
	});
}
