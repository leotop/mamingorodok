$(document).on('input', '#comment', function () {
    if($(this).val().length > 1000){
        $('.purple').prop('disabled', true);
    }else{
        $('.purple').prop('disabled', false);
    }

});