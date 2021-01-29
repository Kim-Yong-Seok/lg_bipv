// hex 값을 rgb로 변환해서 모든 값 rgb로 바꿈
function hexToRgb ( hexType ) {
    // 참고사이트 : https://tonks.tistory.com/130

    var hex = hexType.replace( "#", "" ); 
    var value = hex.match( /[a-f\d]/gi ); 

    // 헥사값이 세자리일 경우, 여섯자리로. 
    if ( value.length == 3 ) hex = value[0] + value[0] + value[1] + value[1] + value[2] + value[2]; 


    value = hex.match( /[a-f\d]{2}/gi ); 

    var r = parseInt( value[0], 16 ); 
    var g = parseInt( value[1], 16 ); 
    var b = parseInt( value[2], 16 ); 

    //var rgbType = "rgb(" + r + ", " + g + ", " + b + ")"; 
    var rgbType = r + ", " + g + ", " + b; 

    return rgbType; 
}

// rgb 값을 원래 값으로 변환
function rgbTolab ( rgbType ) {
    // 쉼표(,)를 기준으로 분리해서, 배열에 담기. 
    var rgb = rgbType.replace( /[^%,-.\d]/g, "" ); 
    rgb = rgb.split( "," );

    R = rgb[0];
    G = rgb[1];
    B = rgb[2];

    var var_R = parseFloat(R/255.0);
    var var_G = parseFloat(G/255.0);
    var var_B = parseFloat(B/255.0);
    
    var var_R_pow = parseFloat((var_R + 0.055 ) / 1.055);
    var var_G_pow = parseFloat((var_G + 0.055 ) / 1.055);
    var var_B_pow = parseFloat((var_B + 0.055 ) / 1.055);

    if ( var_R > 0.04045 ) var_R = Math.pow(var_R_pow, 2.4 );
    else                   var_R = var_R / 12.92;
    if ( var_G > 0.04045 ) var_G = Math.pow(var_G_pow, 2.4);
    else                   var_G = var_G / 12.92;
    if ( var_B > 0.04045 ) var_B = Math.pow(var_B_pow, 2.4);
    else                   var_B = var_B / 12.92;

    var_R = parseFloat(var_R * 100.0);
    var_G = parseFloat(var_G * 100.0);
    var_B = parseFloat(var_B * 100.0);

    //Observer. = 2°, Illuminant = D65
    var X = parseFloat(var_R * 0.4124 + var_G * 0.3576 + var_B * 0.1805);
    var Y = parseFloat(var_R * 0.2126 + var_G * 0.7152 + var_B * 0.0722);
    var Z = parseFloat(var_R * 0.0193 + var_G * 0.1192 + var_B * 0.9505);


    var var_X = parseFloat(X / 95.047) ;         //ref_X =  95.047   Observer= 2°, Illuminant= D65
    var var_Y = parseFloat(Y / 100.000);          //ref_Y = 100.000
    var var_Z = parseFloat(Z / 108.883);          //ref_Z = 108.883

    if ( var_X > 0.008856 ) var_X = Math.pow(var_X , ( 1.0/3.0 ) );
    else                    var_X = ( 7.787 * var_X ) + ( 16.0 / 116.0 );
    if ( var_Y > 0.008856 ) var_Y = Math.pow(var_Y , ( 1.0/3.0 ));
    else                    var_Y = ( 7.787 * var_Y ) + ( 16.0 / 116.0 );
    if ( var_Z > 0.008856 ) var_Z = Math.pow(var_Z , ( 1.0/3.0 ));
    else                    var_Z = ( 7.787 * var_Z ) + ( 16.0 / 116.0 );

    l_s = parseFloat((116.0 * var_Y) - 16.0);
    a_s = parseFloat(500.0 * (var_X - var_Y));
    b_s = parseFloat(200.0 * (var_Y - var_Z));

    l_s = Math.round(l_s);
    a_s = Math.round(a_s);
    b_s = Math.round(b_s);

    result = l_s + ", " + a_s + ", " + b_s;

    return result;
}

function rgbToCmyk ( rgbType ) {
    var rgb = rgbType.replace( /[^%,-.\d]/g, "" );
    rgb = rgb.split( "," ); 

    R = rgb[0];
    G = rgb[1];
    B = rgb[2];

    r = R / 255;
    g = G / 255;
    b = B / 255;

    k = Math.min( 1 - r, 1 - g, 1 - b );
    c = ( 1 - r - k ) / ( 1 - k );
    m = ( 1 - g - k ) / ( 1 - k );
    y = ( 1 - b - k ) / ( 1 - k );

    c = Math.round( c * 100 );
    m = Math.round( m * 100 );
    y = Math.round( y * 100 );
    k = Math.round( k * 100 );

    result = c + ", " + m + ", " + y + ", " + k;

    return result;
}

// hex code로 변환
function labToHex ( labType ) {
    // https://github.com/antimatter15/rgb-lab/blob/master/color.js
    // https://www.easyrgb.com/en/math.php
    // https://www.nixsensor.com/free-color-converter/
    // https://stackoverflow.com/questions/7880264/convert-lab-color-to-rgb

    // 컬러값과 쉼표만 남기고 삭제. 
    var lab = labType.replace( /[^%,-.\d]/g, "" ); 

    // 쉼표(,)를 기준으로 분리해서, 배열에 담기. 
    lab = lab.split( "," ); 

    l_s = lab[0];
    a_s = lab[1];
    b_s = lab[2];

    l_s = parseFloat(l_s);
    a_s = parseFloat(a_s);
    b_s = parseFloat(b_s);

    var_Y = parseFloat(((l_s + 16.0) / 116.0));
    var_X = parseFloat(((a_s / 500.0) + var_Y));
    var_Z = parseFloat((var_Y - (b_s / 200.0)));

    if ( Math.pow(var_X , 3) > 0.008856 ) var_X = Math.pow(var_X , 3);
    else                    var_X = ( var_X - 16.0 / 116.0 ) / 7.787;
    if ( Math.pow(var_Y , 3) > 0.008856 ) var_Y = Math.pow(var_Y , 3);
    else                    var_X = ( var_X - 16.0 / 116.0 ) / 7.787;
    if ( Math.pow(var_Z , 3) > 0.008856 ) var_Z = Math.pow(var_Z , 3);
    else                     var_Z = ( var_Z - 16.0 / 116.0 ) / 7.787;

    var X = parseFloat(var_X * 95.047) ;         //ref_X =  95.047   Observer= 2°, Illuminant= D65
    var Y = parseFloat(var_Y * 100.000);          //ref_Y = 100.000
    var Z = parseFloat(var_Z * 108.883);          //ref_Z = 108.883

    var_X = parseFloat(X / 100.0);
    var_Y = parseFloat(Y / 100.0);
    var_Z = parseFloat(Z / 100.0);

    var var_R = parseFloat(var_X * 3.2406 + var_Y * -1.5372 + var_Z * -0.4986);
    var var_G = parseFloat(var_X * -0.9689 + var_Y * 1.8758 + var_Z * 0.0415);
    var var_B = parseFloat(var_X * 0.0557 + var_Y * -0.2040 + var_Z * 1.0570);

    if ( var_R > 0.0031308 ) var_R = 1.055 * Math.pow(var_R , ( 1 / 2.4 ))  - 0.055;
    else                     var_R = 12.92 * var_R;
    if ( var_G > 0.0031308 ) var_G = 1.055 * Math.pow(var_G , ( 1 / 2.4 ) )  - 0.055;
    else                     var_G = 12.92 * var_G;
    if ( var_B > 0.0031308 ) var_B = 1.055 * Math.pow( var_B , ( 1 / 2.4 ) ) - 0.055;
    else                     var_B = 12.92 * var_B;

    var R = parseFloat(var_R*255.0);
    var G = parseFloat(var_G*255.0);
    var B = parseFloat(var_B*255.0);

    //Return New Color(CSng(X), CSng(Y), CSng(Z))
    rgbType = R + "," + G + "," + B;

    // RGB에서 HEX를 추출하여 반환
    var hexType = rgbToHex(rgbType);

    return hexType;
}

function cmykToHex ( cmykType ) {
    // 컬러값과 쉼표만 남기고 삭제. 
    var cmyk = cmykType.replace( /[^%,-.\d]/g, "" ); 
    cmyk = cmyk.split( "," );

    // https://www.rapidtables.com/convert/color/rgb-to-cmyk.html
    // http://www.easyrgb.com/en/math.php#text20

    // //C, M, Y and K range = 0 ÷ 1.0
    var Cyan		= parseInt(cmyk[ 0 ]) / 100;
    var Magenta		= parseInt(cmyk[ 1 ]) / 100;
    var Yellow		= parseInt(cmyk[ 2 ]) / 100;
    var Black		= parseInt(cmyk[ 3 ]) / 100;

    // CMYK → CMY
    C = ( Cyan * ( 1 - Black ) + Black );
    M = ( Magenta * ( 1 - Black ) + Black );
    Y = ( Yellow * ( 1 - Black ) + Black );

    // CMY → RGB
    //C, M and Y input range = 0 ÷ 1.0
    //R, G and B output range = 0 ÷ 255
    // 38, 0, 22, 78
    Red = ( 1 - C ) * 255;
    Green = ( 1 - M ) * 255;
    Blue = ( 1 - Y ) * 255;

    var rgbType = Red + "," + Green + "," + Blue;
    var hexValue = rgbToHex( rgbType );

    // console.log( hexValue );
    return hexValue; 
}

function rgbToHex ( rgbType ) {
    // 참고사이트 : https://tonks.tistory.com/130

    // 컬러값과 쉼표만 남기고 삭제. 
    var rgb = rgbType.replace( /[^%,-.\d]/g, "" ); 

    // 쉼표(,)를 기준으로 분리해서, 배열에 담기. 
    rgb = rgb.split( "," ); 

    // 컬러값이 "%"일 경우, 변환하기. 
    for ( var x = 0; x < 3; x++ ) { 
            if ( rgb[ x ].indexOf( "%" ) > -1 ) rgb[ x ] = Math.round( parseFloat( rgb[ x ] ) * 2.55 ); 
    } 

    // 16진수 문자로 변환. 
    var toHex = function( string ){ 
            string = parseInt( string, 10 ).toString( 16 ); 
            string = ( string.length === 1 ) ? "0" + string : string; 

            return string; 
    }; 

    var r = toHex( rgb[ 0 ] ); 
    var g = toHex( rgb[ 1 ] ); 
    var b = toHex( rgb[ 2 ] ); 

    var hexType = "#" + r + g + b; 

    return hexType; 
}

function pantoneToHex ( pantoneType ) {
    var result = $.ajax({
        type: 'GET',
        url: './server/color/get_pantone.php?color_code=' + pantoneType + '&color_type=hex',
    });
    return result;
}

function rgbToHsv( r, g, b ) {
    var computedH = 0;
    var computedS = 0;
    var computedV = 0;

    //remove spaces from input RGB values, convert to int
    var r = parseInt( (''+r).replace(/\s/g,''),10 ); 
    var g = parseInt( (''+g).replace(/\s/g,''),10 ); 
    var b = parseInt( (''+b).replace(/\s/g,''),10 ); 

    if ( r==null || g==null || b==null ||
        isNaN(r) || isNaN(g)|| isNaN(b) ) {
    alert ('Please enter numeric RGB values!');
    return;
    }
    if (r<0 || g<0 || b<0 || r>255 || g>255 || b>255) {
    alert ('RGB values must be in the range 0 to 255.');
    return;
    }
    r=r/255; g=g/255; b=b/255;
    var minRGB = Math.min(r,Math.min(g,b));
    var maxRGB = Math.max(r,Math.max(g,b));

    // Black-gray-white
    if (minRGB==maxRGB) {
    computedV = minRGB;
    return [0,0,computedV];
    }

    // Colors other than black-gray-white:
    var d = (r==minRGB) ? g-b : ((b==minRGB) ? r-g : b-r);
    var h = (r==minRGB) ? 3 : ((b==minRGB) ? 1 : 5);
    computedH = 60*(h - d/(maxRGB - minRGB));
    computedS = (maxRGB - minRGB)/maxRGB;
    computedV = maxRGB;
    //return [computedH,computedS,computedV];

    h = computedH;
    s = computedS;
    v = computedV;

    s = s * 100;
    v = v * 100;

    h = h.toFixed(0);
    s = s.toFixed(1);
    v = v.toFixed(1);

    return {h, s, v};
}

function hsvToRgb ( h, s, v ) {
    var r, g, b;
    var i;
    var f, p, q, t;
        
    // Make sure our arguments stay in-range
    h = Math.max(0, Math.min(360, h));
    s = Math.max(0, Math.min(100, s));
    v = Math.max(0, Math.min(100, v));
        
    // We accept saturation and value arguments from 0 to 100 because that's
    // how Photoshop represents those values. Internally, however, the
    // saturation and value are calculated from a range of 0 to 1. We make
    // That conversion here.
    s /= 100;
    v /= 100;
    
    if(s == 0) {
        // Achromatic (grey)
        r = g = b = v;
        return [
            Math.round(r * 255), 
            Math.round(g * 255), 
            Math.round(b * 255)
        ];
    }
    
    h /= 60; // sector 0 to 5
    i = Math.floor(h);
    f = h - i; // factorial part of h
    p = v * (1 - s);
    q = v * (1 - s * f);
    t = v * (1 - s * (1 - f));
    
    switch(i) {
        case 0:
            r = v;
            g = t;
            b = p;
            break;
        
        case 1:
            r = q;
            g = v;
            b = p;
            break;
        
        case 2:
            r = p;
            g = v;
            b = t;
            break;
        
        case 3:
            r = p;
            g = q;
            b = v;
            break;
        
        case 4:
            r = t;
            g = p;
            b = v;
            break;
        
        default: // case 5:
            r = v;
            g = p;
            b = q;
    }

    r = Math.round(r * 255);
    g = Math.round(g * 255);
    b = Math.round(b * 255);
     
    rgb = r + ", " + g + ", " + b;
    return rgb;
}

function rgbToHexWithPV ( targetType, rgbType, pv ) {
   // 컬러값과 쉼표만 남기고 삭제. 
   var rgb = rgbType.replace( /[^%,-.\d]/g, "" ); 

   // 쉼표(,)를 기준으로 분리해서, 배열에 담기. 
   rgb = rgb.split( "," ); 

   r = rgb[0];
   g = rgb[1];
   b = rgb[2];

   var codes = rgbToHsv(r,g,b);
   var h = codes.h;
   var s = codes.s;
   var v = codes.v;

   console.log( 'h : ' +  h );
   console.log( 's : ' +  s );
   console.log( 'v : ' +  v );

   pv = parseInt(pv);

   var v = Math.round(v);


   if (pv >= 75) {
       if( targetType == 'T' ) v = v * 4;
       else v = v / 4;
   } 
//    else if (pv > 50) {
//        if( targetType == 'T' ) v = (2 + (pv - 50) * 0.08) * v;
//        else v = (pv/v - 2)/0.08 + 50;
//    } 
   else if (pv == 50) {
       if( targetType == 'T' ) v = v * 2;
       else v = v / 2;
   }
//    else if (pv > 25) {
//        if( targetType == 'T' ) v = (1.36 + (pv - 25) * 0.0246) * v;
//        else v = (pv/v - 1.36)/0.0246 + 25;
//    }
   else if (pv == 25) {
       if( targetType == 'T' ) v = v * 1.36;
       else v = v / 1.36;
   }
   else if (pv == 0) {
       v = v * 1;
   }
   else {
       alert("Please input the correct PV value");				
   }
   console.log( v );
//    if (v > 100) {
//        alert("This color's brightness is over 100%");
//        return;
//    }

   if(typeof v == "undefined" || v == null || v == "") {
       alert("Brightness is undefined");
       return;
   }

    var rgb = hsvToRgb( h, s, v ); 
    var noneFixedHex = rgbToHex(rgb);

    // PV값 바로 직전값으로 변경
    // $("#slider-value").html($("#pre_pv").val());
    // $( "#slider" ).slider( "option", "value", $("#pre_pv").val() );
    // surfaceColor_hex = "";

//    console.log( 'pv : ' +  pv );
//    console.log( 'surfaceColor_hex : ' +  surfaceColor_hex );

   return noneFixedHex;
}

function hexToHsl(hex){

    // https://www.html-code-generator.com/javascript/color-converter-script
    hex = hex.replace(/#/g, '');
    if (hex.length === 3) {
        hex = hex.split('').map(function (hex) {
            return hex + hex;
        }).join('');
    }
    var result = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})[\da-z]{0,0}$/i.exec(hex);
    if (!result) {
        return null;
    }
    var r = parseInt(result[1], 16);
    var g = parseInt(result[2], 16);
    var b = parseInt(result[3], 16);
    r /= 255, g /= 255, b /= 255;
    var max = Math.max(r, g, b),
        min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;
    if (max == min) {
        h = s = 0;
    } else {
        var d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
        case r:
            h = (g - b) / d + (g < b ? 6 : 0);
            break;
        case g:
            h = (b - r) / d + 2;
            break;
        case b:
            h = (r - g) / d + 4;
            break;
        }
        h /= 6;
    }
    s = s * 100;
    s = Math.round(s);
    l = l * 100;
    l = Math.round(l);
    h = Math.round(360 * h);

    console.log( h, s, l );

	return h + "," + s + "," + l;

}

function hslToHex(hslType){

	// 컬러값과 쉼표만 남기고 삭제. 
	var hsl = hslType.replace( /[^%,.\d]/g, "" ); 

	// 쉼표(,)를 기준으로 분리해서, 배열에 담기. 
	hsl = hsl.split( "," );

	var h = hsl[0];
	var s = hsl[1];
	var l = hsl[2];

	// https://stackoverflow.com/questions/36721830/convert-hsl-to-rgb-and-hex

	h /= 360;
	s /= 100;
	l /= 100;
	let r, g, b;

	if (s === 0) {
		r = g = b = l; // achromatic
	} else {
		const hue2rgb = (p, q, t) => {
			if (t < 0) t += 1;
			if (t > 1) t -= 1;
			if (t < 1 / 6) return p + (q - p) * 6 * t;
			if (t < 1 / 2) return q;
			if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
			return p;
		};
		const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
		const p = 2 * l - q;
		r = hue2rgb(p, q, h + 1 / 3);
		g = hue2rgb(p, q, h);
		b = hue2rgb(p, q, h - 1 / 3);
	}
	const toHex = x => {
		const hex = Math.round(x * 255).toString(16);
		return hex.length === 1 ? '0' + hex : hex;
	};

	output_hex = "#"+toHex(r)+toHex(g)+toHex(b);

	return output_hex;


}

function hslToHex(hslType){

	// 컬러값과 쉼표만 남기고 삭제. 
	var hsl = hslType.replace( /[^%,.\d]/g, "" ); 

	// 쉼표(,)를 기준으로 분리해서, 배열에 담기. 
	hsl = hsl.split( "," );

	var h = hsl[0];
	var s = hsl[1];
	var l = hsl[2];

	// https://stackoverflow.com/questions/36721830/convert-hsl-to-rgb-and-hex

	h /= 360;
	s /= 100;
	l /= 100;
	let r, g, b;

	if (s === 0) {
		r = g = b = l; // achromatic
	} else {
		const hue2rgb = (p, q, t) => {
			if (t < 0) t += 1;
			if (t > 1) t -= 1;
			if (t < 1 / 6) return p + (q - p) * 6 * t;
			if (t < 1 / 2) return q;
			if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
			return p;
		};
		const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
		const p = 2 * l - q;
		r = hue2rgb(p, q, h + 1 / 3);
		g = hue2rgb(p, q, h);
		b = hue2rgb(p, q, h - 1 / 3);
	}
	const toHex = x => {
		const hex = Math.round(x * 255).toString(16);
		return hex.length === 1 ? '0' + hex : hex;
	};

	output_hex = "#"+toHex(r)+toHex(g)+toHex(b);

	return output_hex;


}