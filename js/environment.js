function showTextInput( id ) {
    if( $('#'+id).val() == 'Etc' && !$('#'+id+'_input').is(':visible') ) $('#'+id+'_input').show();
    else if( $('#'+id).val() != 'Etc' && $('#'+id+'_input').is(':visible') ) $('#'+id+'_input').hide();

    console.log
}

function reset() {
    $('#eGlassType').val( 'Float Tempered' );
    $('#eGlassTexture').val( '5T' );
    $('#eGlassThickness').val( 'Semi-gloss' );
    $('#ePrintingType1').val( 'Ceramic' );
    $('#ePrintingType1_input > input').val( '' );
    $('#ePrintingType1_input').css('display', 'none');
    $('#ePrintingType2').val( 'Silk' );
    $('#ePattern').val( 'Geometric' );
    $('#eContinent').val( 'Asia' );
    $('#eCountry').val( 'Republic of Korea' );
    $('#eContinent_input > input').val( '' );
    $('#eContinent_input').css('display', 'none');
    $('#eIlluminant').val( '65D' );
    $('#eIlluminant_input').hide();
    $('#eIlluminant_input > input').val( '' );
    $('#eDistance').val( '3M' );
}

function save() {
    $('#form').submit();
}