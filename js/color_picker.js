var purposeTarget = 'T';
var FIXED_HEX_CODE = '';
var NONE_FIXED_HEX_CODE = '';
var ORIGIN_NONE_FIXED_HEX_CODE = '';
var changeCnt = 0;

function goToCamera() {
    HybridApp.CallAndroid();
}

function getAndroid( rgb ) {
    var value = rgb.split(',');
    
    var r = value[0];
    var g = value[1];
    var b = value[2];

    $('#inputCodeType').val('rgb');
    $('#ibv1_1').val(r);
    $('#ibv1_2').val(g);
    $('#ibv1_3').val(b);

    setColor();
}

function setName() {
    var name;
    var code = NONE_FIXED_HEX_CODE;
    const date = new Date();
    const today = date.getDate();
    var month = date.getMonth() + 1;
    month = month >= 10 ? month : '0' + month;
    const year = date.getFullYear();
    console.log( code );
    name = 'G'+code.substr(1, 2)+'-50-'+year+month+today;
    $('#pjtName').val( name );
}

function addNewColor() {
    $('#fixedHexValue').val(FIXED_HEX_CODE);
    $('#noneFixedHexValue').val(NONE_FIXED_HEX_CODE);
    
    if( !FIXED_HEX_CODE || !NONE_FIXED_HEX_CODE ) {
        alert('Please enter color code.');
        return;
    }else {
        var data = $('#addNewColorForm').serialize();
        $.ajax({
            type: 'post',
            url: './server/color/add_new_color.php',
            data: data,
            success: ( response ) => {
                if( response == '1' ) {
                    location.href='./home.php';
                } else {
                    showAlert('Invalid data');
                }
            },
        });
    }
}

function updateText() {
    var idx = $('#idx').val();
    $('#fixedHexValue').val(FIXED_HEX_CODE);
    $('#noneFixedHexValue').val(NONE_FIXED_HEX_CODE);

    $.ajax({
        url: './server/color/update_text.php',
        data: $('#addNewColorForm').serialize(),
        method: 'post',
        success: ( response ) => {
            if( response == '1' ) {
                location.href='./project_preview.php?id='+idx;
            } else {
                showAlert('Update Failed');
            }
        }
    });
}

function validate() {
    var idx = $('#idx').val();
    $.ajax({
        url: './server/color/validate.php',
        method: 'post',
        data: {
            idx: idx
        },
        success: ( response ) => {
            if( response == '1' ) {
                location.href='./home.php';
            } else {
                showAlert('Validate Failed');
            }
        }
    })
}

function reset () {
    console.log('RESET!');

    $('.fixedTarget, .noneFixedTarget').find('span').text('');
    $('.fixedTarget, .noneFixedTarget').find('p').text('');

    $('#targetColor, #surfaceColor').removeClass('fixedTarget');
    $('#targetColor, #surfaceColor').removeClass('noneFixedTarget');

    $('#inputCodeType').val('lab');
    $('#ibv1_1').val('');
    $('#ibv1_2').val('');
    $('#ibv1_3').val('');

    $('#ibv2_1').val('');
    $('#ibv2_2').val('');
    $('#ibv2_3').val('');
    $('#ibv2_4').val('');
    
    $('#ibv3_1').val('');
    $('#ibv3_2').val('');
    
    $('#targetColor').css('background-color', '');
    $('#surfaceColor').css('background-color', '');
    $('#pvTable').css('background-color', '');
    
    $('#pvTable').removeClass();
    $('#pvTable').addClass('color_ratio pv50 noneFixedTarget');
    $('#pvSlider').slider('option', 'value', 50);
    $('#pvSliderValue').html(50);

    $("#pvSlider .ui-slider-range").css( "background-color", '' );
    $("#brightSlider .ui-slider-range").css( "background-color", '' );
    $("#toneSlider .ui-slider-range").css( "background-color", '' );
    $('#hueSlider .ui-slider-range').css( "background-color", '' );

    $('#pvValue').val('');
    $('#brightnessValue').val('');
    $('#saturationValue').val('');
    $('#hueValue').val('');

    NONE_FIXED_HEX_CODE = '';
    FIXED_HEX_CODE = '';
    ORIGIN_NONE_FIXED_HEX_CODE = '';
}

function selectTarget () {
    reset();
    if( $('#chkAccept1').is(':checked') ) {
        $('#targetColor').addClass('noneFixedTarget');
        $("#surfaceColor").addClass('fixedTarget');
        purposeTarget = 'S';
    }else {
        $('#targetColor').addClass('fixedTarget');
        $('#surfaceColor').addClass('noneFixedTarget');
        purposeTarget = 'T';
    }
    
}

function selectCodeType () {
    const type = $('#inputCodeType').val();
    if( type == "lab" || type == "rgb" ) {
        $('#inputCodeBox1').css("display", "inline-block");
        $('#inputCodeBox2').css("display", "none");
        $('#inputCodeBox3').css("display", "none");
    } else if( type == "cmyk" ) {
        $('#inputCodeBox1').css("display", "none");
        $('#inputCodeBox2').css("display", "inline-block");
        $('#inputCodeBox3').css("display", "none");
    } else {
        $('#inputCodeBox1').css("display", "none");
        $('#inputCodeBox2').css("display", "none");
        $('#inputCodeBox3').css("display", "inline-block");
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
    var inputCodeValue = getInputCode();
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

    function getInputCode () {
        var inputCodeValue = '';
        if( inputCodeType == 'lab' || inputCodeType == 'rgb' ) {
            inputCodeValue = $('#ibv1_1').val() + "," + $('#ibv1_2').val() + "," + $('#ibv1_3').val(); 
        } else if ( inputCodeType == 'cmyk' ) {
            inputCodeValue = $('#ibv2_1').val() + ", " + $('#ibv2_2').val() + ", " + $('#ibv2_3').val() + ", " + $('#ibv2_4').val();
        } else {
            // inputCodeValue = $('#ibv3_1').val() + "-" + $('#ibv3_2').val();
            inputCodeValue = $('#ibv3_1').val();
        }
        return inputCodeValue;
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
            alert('This color can not be maked.');
            return;
        }
        var noneRgb = hexToRgb( hexCode );
        console.log( noneRgb );
        var noneHexCode = rgbToHexWithPV( purposeTarget, noneRgb, 50 );
        console.log( noneHexCode );
        var noneHsl = hexToHsl( noneHexCode );

        // console.log( noneHsl );
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
            $('#hueSlider').slider( 'option', 'value', h);

            $('.fixedTarget > p').text( hexCode );
            $('.noneFixedTarget > p').text( noneHexCode );


            FIXED_HEX_CODE = hexCode;
            NONE_FIXED_HEX_CODE = noneHexCode;
            ORIGIN_NONE_FIXED_HEX_CODE = noneHexCode;
            chageCnt = 0;
            changePv( 50 );
        } else {
            alert('Some error occured!!');
            return;
        }
    });

}

function changePv ( pv ) {
    console.log( pv );
    var noneRgb = hexToRgb( FIXED_HEX_CODE );
    var noneHexCode = rgbToHexWithPV( purposeTarget, noneRgb, pv );
    var hsl = hexToHsl( noneHexCode ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;

    $("#pvSliderValue").html( pv );
    $('#pvSliderValue2').html( 100 - pv );

    $("#pvTable").removeClass();
    $("#pvTable").addClass("color_ratio noneFixedTarget pv" + pv);

    $('.fixedTarget').css('background-color', FIXED_HEX_CODE);
    $('.noneFixedTarget').css('background-color', noneHexCode);

    $('#brightSlider').slider( 'option', 'value', l );
    $('#toneSlider').slider( 'option', 'value', s );
    $('#hueSlider').slider( 'option', 'value', h );

    $('#pvValue').val( pv );
    $('#brightnessValue').val( l );
    $('#saturationValue').val( s );
    $('#hueValue').val( h );

    var barColor = getTheColor( noneHexCode );
    $("#pvSlider .ui-slider-range").css( "background-color", barColor );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );
    
    $('.fixedTarget > p').text( FIXED_HEX_CODE );
    $('.noneFixedTarget > p').text( noneHexCode );

    if( purposeTarget == 'T' ) {
        if( pv == 0 ) $('#pvTable').css("background-color", FIXED_HEX_CODE);
    } else {
        if( pv != 0 && pv != 100 ) $('#pvTable').css("background-color", FIXED_HEX_CODE );
    }

    var expectedPower = '';
    switch( pv ) {
        case 100:
            expectedPower = '361 (19%)';
            break;
        case 75:
            expectedPower = '325 (17.1%)';
            break;
        case 50:
            expectedPower = '289 (15.2%)';
            break;
        case 25:
            expectedPower = '253 (13.3%)';
            break;
        case 0:
            expectedPower = '217 (11.4%)';
            break;
        default:
            break;
    }
    
    $('#expectedPower').val( expectedPower );
    // console.log( expectedPower );
    NONE_FIXED_HEX_CODE = noneHexCode.toUpperCase();
    ORIGIN_NONE_FIXED_HEX_CODE = noneHexCode.toUpperCase();

    if( typeof changeCnt != 'undefined' && changeCnt > 0 ) {
        $('#saveBTN').show();
        $('#updateBTN').hide();
    }
    if( typeof changeCnt != 'undefined' ) {
        changeCnt = 0;
        changeCnt++;
    }
    
}

function changeBright ( bright ) {
    var hsl = hexToHsl( NONE_FIXED_HEX_CODE ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;
    var newHsl = h + "," + s + "," + bright;
    var newHex = hslToHex( newHsl );

    var light = newHex;
    
    $('.noneFixedTarget').css('background-color', light );
    $('#brightnessValue').val( bright );

    var barColor = getTheColor( light );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );
    $("#hueSlider .ui-slider-range").css( "background-color", barColor );

    $('.noneFixedTarget > p').text( light );
    // $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( light ) ) );
    // $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( light ) ) );
    // $('.noneFixedTarget > span#rgbValue').text( hexToRgb( light ) );
    // $('.noneFixedTarget > span#hexValue').text( light.toUpperCase() );

    NONE_FIXED_HEX_CODE = light.toUpperCase();
    $('#saveBTN').show();
    $('#updateBTN').hide();
}

function changeTone ( tone ) {
    var hsl = hexToHsl( NONE_FIXED_HEX_CODE ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;
    var newHsl = h + "," + tone + "," + l;
    var newHex = hslToHex( newHsl );
    
    var newHexCode = newHex;

    $(".noneFixedTarget").css( 'background-color', newHexCode );
    $('#saturationValue').val( tone );

    var barColor = getTheColor( newHexCode );
    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );
    $("#hueSlider .ui-slider-range").css( "background-color", barColor );

    $('.noneFixedTarget > p').text( newHexCode );
    // $('.noneFixedTarget > span#labValue').text( rgbTolab( hexToRgb( newHexCode ) ) );
    // $('.noneFixedTarget > span#cmykValue').text( rgbToCmyk( hexToRgb( newHexCode ) ) );
    // $('.noneFixedTarget > span#rgbValue').text( hexToRgb( newHexCode ) );
    // $('.noneFixedTarget > span#hexValue').text( newHexCode.toUpperCase() );

    NONE_FIXED_HEX_CODE = newHexCode.toUpperCase();
    $('#saveBTN').show();
    $('#updateBTN').hide();
}

function changeHue ( hue ) {
    var hsl = hexToHsl( NONE_FIXED_HEX_CODE ).replace( /[^%,.\d]/g, "" ).split(',');
    var [h, s, l] = hsl;
    var newHsl = hue + "," + s + "," + l;
    var newHex = hslToHex( newHsl );

    var newHexCode = newHex;
    
    $(".noneFixedTarget").css( 'background-color', newHexCode );
    $('#hueValue').val( hue );

    var barColor = getTheColor( newHexCode );

    $("#brightSlider .ui-slider-range").css( "background-color", barColor );
    $("#toneSlider .ui-slider-range").css( "background-color", barColor );
    $("#hueSlider .ui-slider-range").css( "background-color", barColor );

    $('.noneFixedTarget > p').text( newHexCode );

    NONE_FIXED_HEX_CODE = newHexCode.toUpperCase();
    $('#saveBTN').show();
    $('#updateBTN').hide();
}

function getTheColor( colorVal ) {
    var theColor = "";

    theColor = hexToRgb( colorVal )
    theColor = "rgb(" + theColor + ")";

    return theColor; 
}