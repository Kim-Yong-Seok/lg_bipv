$(function() {

    // PV 비율
    $("#pvSlider").slider({
    orientation: "horizontal",
    range: "min",
    value: 50,
    min: 0,
    max: 75,
    step: 25,
    slide: function( event, ui ) {
        num = parseInt( ui.value );

        $("#prePvValue").val($("#pvSliderValue").html());
        changePv( Math.abs(num) );

        var noneFixedHex1 = $("#noneFixedHex1").val();
        $("#pvSlider").css('background', 'linear-gradient(90deg, ' + noneFixedHex1 + ' ' + ui.value + '%, #000000 0%)');
        $("#pvSliderValue").html(num);
    }
    });

    // Brightness
    $("#brightSlider").slider({
    orientation: "horizontal",
    range: "min",
    value: 50,
    min: 0,
    max: 100,
    step: 1,
    slide: function( event, ui ) {
        num = parseInt( ui.value );
        
        changeBright( Math.abs( num ) );
        $("#brightSliderValue").html(num);
    }
    });

    // Saturation
    $("#toneSlider").slider({
    orientation: "horizontal",
    range: "min",
    value: 1,
    min: 0,
    max: 100,
    step: 1,
    slide: function( event, ui ) {
        num = parseInt(ui.value);

        changeTone(num);
        $("#toneSliderValue").html(num);
    }
    });

    $("#pvSliderValue").html($('#pvSlider').slider('value'));
    $("#brightSliderValue").html($('#brightSlider').slider('value'));
    $("#toneSliderValue").html($('#toneSlider').slider('value'));

});

function applySaturationToHexColor(hex, saturationPercent) {
    //https://stackoverflow.com/questions/13806483/increase-or-decrease-color-saturation

    if (!/^#([0-9a-f]{6})$/i.test(hex)) {
        throw('Unexpected color format');
    }

    if (saturationPercent < 0 || saturationPercent > 100) {
        throw('Unexpected color format');
    }

    var saturationFloat   = saturationPercent / 100,
        rgbIntensityFloat = [
            parseInt(hex.substr(1,2), 16) / 255,
            parseInt(hex.substr(3,2), 16) / 255,
            parseInt(hex.substr(5,2), 16) / 255
        ];

    var rgbIntensityFloatSorted = rgbIntensityFloat.slice(0).sort(function(a, b){ return a - b; }),
        maxIntensityFloat       = rgbIntensityFloatSorted[2],
        mediumIntensityFloat    = rgbIntensityFloatSorted[1],
        minIntensityFloat       = rgbIntensityFloatSorted[0];

    if (maxIntensityFloat == minIntensityFloat) {
        // All colors have same intensity, which means 
        // the original color is gray, so we can't change saturation.
        return hex;
    }

    // New color max intensity wont change. Lets find medium and weak intensities.
    var newMediumIntensityFloat,
        newMinIntensityFloat = maxIntensityFloat * (1 - saturationFloat);

    if (mediumIntensityFloat == minIntensityFloat) {
        // Weak colors have equal intensity.
        newMediumIntensityFloat = newMinIntensityFloat;
    }
    else {
        // Calculate medium intensity with respect to original intensity proportion.
        var intensityProportion = (maxIntensityFloat - mediumIntensityFloat) / (mediumIntensityFloat - minIntensityFloat);
        newMediumIntensityFloat = (intensityProportion * newMinIntensityFloat + maxIntensityFloat) / (intensityProportion + 1);
    }

    var newRgbIntensityFloat       = [],
        newRgbIntensityFloatSorted = [newMinIntensityFloat, newMediumIntensityFloat, maxIntensityFloat];

    // We've found new intensities, but we have then sorted from min to max.
    // Now we have to restore original order.
    rgbIntensityFloat.forEach(function(originalRgb) {
        var rgbSortedIndex = rgbIntensityFloatSorted.indexOf(originalRgb);
        newRgbIntensityFloat.push(newRgbIntensityFloatSorted[rgbSortedIndex]);
    });

    var floatToHex = function(val) { return ('0' + Math.round(val * 255).toString(16)).substr(-2); },
        rgb2hex    = function(rgb) { return '#' + floatToHex(rgb[0]) + floatToHex(rgb[1]) + floatToHex(rgb[2]); };

    var newHex = rgb2hex(newRgbIntensityFloat);

    return newHex;
}