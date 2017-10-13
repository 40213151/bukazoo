$(function() {
    $('#tab2').click(function(){
        $('#signin').show();
        $('#signup').hide();
    });
});
$(function() {
    $('#tab3').click(function(){
        $('#signup').show();
        $('#signin').hide();
    });
});

$(function() {
    $('#checkbox1').change(function(){
        if ( $(this).prop('checked') ) {
            $('#password').attr('type','text');
        } else {
            $('#password').attr('type','password');
        }
    });
});
