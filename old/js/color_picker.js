var purposeTarget = 'T';
var FIXED_HEX_CODE = '';
var NONE_FIXED_HEX_CODE = '';
var ORIGIN_NONE_FIXED_HEX_CODE = '';

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
        if( !hexCode ) {
            alert('This color can not maked.');
            return;
        }
        var noneRgb = hexToRgb( hexCode );
        var noneHexCode = rgbToHexWithPV( purposeTarget, noneRgb, 50 );
        var noneHsl = hexToHsl( noneHexCode );

        console.log( noneHsl );
        var hsl = noneHsl.replace( /[^%,.\d]/g, "" ).split(',');
        var h = hsl[0];
        var s = hsl[1];
        var l = hsl[2];

        if( noneHexCode && hexCode && noneHsl ) {
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

            $('#brightSlider').slider( 'option', 'value', l );
            $('#toneSlider').slider( 'option', 'value', s);

            $('#brightSliderValue').html(l);
            $('#toneSliderValue').html(s);

            FIXED_HEX_CODE = hexCode;
            NONE_FIXED_HEX_CODE = noneHexCode;
            ORIGIN_NONE_FIXED_HEX_CODE = noneHexCode;
        } else {
            alert('Some error occured!!');
            return;
        }
    });

}

function changePv ( pv ) {
    var noneRgb = hexToRgb( FIXED_HEX_CODE );
    var noneHexCode = rgbToHexWithPV( purposeTarget, noneRgb, pv );
    var hsl = hexToHsl( noneHexCode ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;


    $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( noneHexCode ) ) );
    $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( noneHexCode ) ) );
    $('.noneFixedTarget > span#rgbValue').text( hexToRgb( noneHexCode ) );
    $('.noneFixedTarget > span#hexValue').text( noneHexCode.toUpperCase() );

    $('.noneFixedTarget').css('background-color', noneHexCode);

    $('#brightSlider').slider( 'option', 'value', l );
    $('#toneSlider').slider( 'option', 'value', s);

    $('#brightSliderValue').html(l);
    $('#toneSliderValue').html(s);

    var barColor = getTheColor( noneHexCode );
    $("#pvSlider .ui-slider-range").css( "background-color", barColor );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );
    
    NONE_FIXED_HEX_CODE = noneHexCode.toUpperCase();
    ORIGIN_NONE_FIXED_HEX_CODE = noneHexCode.toUpperCase();

}

function changeBright ( bright ) {
    var hsl = hexToHsl( NONE_FIXED_HEX_CODE ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;
    var newHsl = h + "," + s + "," + bright;
    var newHex = hslToHex( newHsl );

    var light = newHex;
    
    $('.noneFixedTarget').css('background-color', light );

    var barColor = getTheColor( light );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );

    $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( light ) ) );
    $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( light ) ) );
    $('.noneFixedTarget > span#rgbValue').text( hexToRgb( light ) );
    $('.noneFixedTarget > span#hexValue').text( light.toUpperCase() );

    NONE_FIXED_HEX_CODE = light.toUpperCase();
}

function changeTone ( tone ) {
    var hsl = hexToHsl( NONE_FIXED_HEX_CODE ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;
    var newHsl = h + "," + tone + "," + l;
    var newHex = hslToHex( newHsl );
    
    var newHexCode = newHex;

    var barColor = getTheColor( newHexCode );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );

    $(".noneFixedTarget").css( 'background-color', newHexCode );

    $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( newHexCode ) ) );
    $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( newHexCode ) ) );
    $('.noneFixedTarget > span#rgbValue').text( hexToRgb( newHexCode ) );
    $('.noneFixedTarget > span#hexValue').text( newHexCode.toUpperCase() );

    NONE_FIXED_TONE_CODE = newHexCode.toUpperCase();
}

function getTheColor( colorVal ) {
    var theColor = "";

    theColor = hexToRgb( colorVal )
    theColor = "rgb(" + theColor + ")";

    return theColor; 
}