var purposeTarget = 'T';
var FIXED_HEX_CODE = '';
var NONE_FIXED_HEX_CODE = '';
var NONE_FIXED_BRIGHT_CODE = '';
var NONE_FIXED_TONE_CODE = '';

function reset () {
    console.log('RESET!');

    $('.fixedTarget, .noneFixedTarget').find('span').text('');

    $('#targetColor, #surfaceColor').removeClass('fixedTarget');
    $('#targetColor, #surfaceColor').removeClass('noneFixedTarget');

    $('#inputCodeType').val('lab');
    $('#inputCodeValue').val('');

    $('#targetSel').removeClass('buttonC');
    $('#surfaceSel').removeClass('buttonC');
    
    $('#targetColor').css('background-color', '');
    $('#surfaceColor').css('background-color', '');

    $("#pvSlider .ui-slider-range").css( "background-color", '' );
    $("#brightSlider .ui-slider-range").css( "background-color", '' );
    $("#toneSlider .ui-slider-range").css( "background-color", '' );

    $( "#brightSlider" ).slider( "option", "value", 0 );
    $( "#toneSlider" ).slider( "option", "value", 0 );
}

function selectTarget ( target ) {
    reset();
    if( target == 't' ) {
        $('#targetColor').addClass('fixedTarget');
        $('#targetSel').addClass('buttonC');
        $('#surfaceColor').addClass('noneFixedTarget');
        purposeTarget = 'T';
    }else {
        $('#targetColor').addClass('noneFixedTarget');
        $('#surfaceSel').addClass('buttonC');
        $("#surfaceColor").addClass('fixedTarget');
        purposeTarget = 'S';
    }
    
}

async function getHexCode ( type, value ) {
    var hexCode = '';

    switch ( type ) {
        case 'lab':
            hexCode = labToHex( value );
            break;
        case 'cmyk':
            hexCode = cmykToHex( value );
            break;
        case 'rgb':
            hexCode = rgbToHex( value );
            break;
        case 'pantone':
            var jsonData = await pantoneToHex( value );
            hexCode = JSON.parse( jsonData ).hex;
            break;
    }

    return hexCode;
}

function getBackgroundColor ( hexCode ) {
    var backgroundColor = '';
    backgroundColor = hexToRgb( hexCode );
    backgroundColor = 'rgb(' + backgroundColor + ')';
    return backgroundColor;
}

function setColor () {
    var inputCodeType = $("#inputCodeType").val();
    var inputCodeValue = $("#inputCodeValue").val();
    var codeValue = '';
    var codeCnt = 0;
    var hexCode = '';


    function checkCount ( type, count ) {
        var value = false;

        switch ( type ) {
            case 'lab':
                value = count == 3 && true;
                break;
            case 'rgb':
                value = count == 3 && true;
                break;
            case 'cmyk':
                value = count == 4 && true;
                break;
            case 'pantone':
                value = true;
                break;
            default:
                break;
        }

        return value;
    }

    if( !inputCodeValue ) {
        alert('Please input a color code.');
        return;
    }

    if( inputCodeType != 'pantone' ) {
        codeValue = inputCodeValue.replace( /[^%,-.\d]/g, "" );
        codeValue = codeValue.split(',');
        codeCnt = codeValue.length;
    }

    console.log("Input values: ", inputCodeType, inputCodeValue, codeCnt);

    if( !checkCount( inputCodeType, codeCnt ) ) {
        alert('Please input the color code correctly.');
        return;
    }
    
    hexCode = getHexCode( inputCodeType, inputCodeValue ).then(( hexCode ) => {
        console.log("Hex Code: ", hexCode);

        var noneRgb = hexToRgb( hexCode );
        var noneHexCode = rgbToHexWithPV( purposeTarget, noneRgb, 50 );
        
        if( noneHexCode && hexCode ) {
            $('.fixedTarget > span#labValue').text( rgbTolab( hexToRgb( hexCode ) ) );
            $('.fixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( hexCode ) ) );
            $('.fixedTarget > span#rgbValue').text( hexToRgb( hexCode ) );
            $('.fixedTarget > span#hexValue').text( hexCode.toUpperCase() );

            $('.fixedTarget').css('background-color', hexCode);
            
            $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( noneHexCode ) ) );
            $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( noneHexCode ) ) );
            $('.noneFixedTarget > span#rgbValue').text( hexToRgb( noneHexCode ) );
            $('.noneFixedTarget > span#hexValue').text( noneHexCode.toUpperCase() );

            $('.noneFixedTarget').css('background-color', noneHexCode);

            var barColor = getTheColor( noneHexCode );
            $("#pvSlider .ui-slider-range").css( "background-color", barColor );
            $("#brightSlider .ui-slider-range").css( "background-color", barColor );
            $("#toneSlider .ui-slider-range").css( "background-color", barColor );

            FIXED_HEX_CODE = hexCode;
            NONE_FIXED_HEX_CODE = noneHexCode;
            NONE_FIXED_BRIGHT_CODE = noneHexCode;
            NONE_FIXED_TONE_CODE = noneHexCode;
        }
    });

}

function changePv ( pv ) {
    var noneRgb = hexToRgb( FIXED_HEX_CODE );
    var noneHexCode = rgbToHexWithPV( purposeTarget, noneRgb, pv );

    $('#brightSliderValue').html(0);
    $('#toneSliderValue').html(0);
    
    $( "#brightSlider" ).slider( "option", "value", 0 );
    $( "#toneSlider" ).slider( "option", "value", 0 );
    
    $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( noneHexCode ) ) );
    $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( noneHexCode ) ) );
    $('.noneFixedTarget > span#rgbValue').text( hexToRgb( noneHexCode ) );
    $('.noneFixedTarget > span#hexValue').text( noneHexCode.toUpperCase() );

    $('.noneFixedTarget').css('background-color', noneHexCode);
}

function changeBright ( option, bright ) {
    var light;
    // 명도를 변경시는 채도 초기화
    $('#toneSliderValue').html(0); 
    $('#toneSlider').slider( "option", "value", 0 );

    function colorLuminance( hex, lum ) {
        hex = String(hex).replace(/[^0-9a-f]/gi, "");
        if (hex.length < 6) {
            hex = hex.replace(/(.)/g, '$1$1');
        }

        lum = lum || 0;

        var hexCode = "#", c;

        for (var i = 0; i < 3; ++i) {
            c = parseInt(hex.substr(i * 2, 2), 16);
            c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
            hexCode += ("00" + c).substr(c.length);
        }

        return hexCode;
    }

    if( option == 'lighter' ) light = colorLuminance( NONE_FIXED_HEX_CODE, (bright * 0.01) )
    else if( option == 'darker' ) light = colorLuminance( NONE_FIXED_HEX_CODE, -(bright * 0.01) );
    
    $('.noneFixedTarget').css('background-color', light );

    var barColor = getTheColor( light );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );

    $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( light ) ) );
    $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( light ) ) );
    $('.noneFixedTarget > span#rgbValue').text( hexToRgb( light ) );
    $('.noneFixedTarget > span#hexValue').text( light.toUpperCase() );

    NONE_FIXED_BRIGHT_CODE = light.toUpperCase();

}

function changeTone ( tone ) {

    hex = NONE_FIXED_BRIGHT_CODE;

    var newHexCode = applySaturationToHexColor( hex, tone );

    var barColor = getTheColor( newHexCode );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );

    NONE_FIXED_TONE_CODE = newHexCode.toUpperCase();

    $(".noneFixedTarget").css( 'background-color', newHexCode );

    $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( newHexCode ) ) );
    $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( newHexCode ) ) );
    $('.noneFixedTarget > span#rgbValue').text( hexToRgb( newHexCode ) );
    $('.noneFixedTarget > span#hexValue').text( newHexCode.toUpperCase() );
}

function getTheColor( colorVal ) {
    var theColor = "";

    theColor = hexToRgb( colorVal )
    theColor = "rgb(" + theColor + ")";

    return theColor; 
}