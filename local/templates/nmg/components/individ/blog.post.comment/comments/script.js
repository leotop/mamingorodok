$(document).on('input', '#comment', function () {
    if($(this).val().length > 1000){
        console.log($(this).val().length);
        $('.purple').prop('disabled', true);
    }else{
        $('.purple').prop('disabled', false);
    }

});