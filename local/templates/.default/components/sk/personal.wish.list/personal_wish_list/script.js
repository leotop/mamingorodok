$(function() {
    $(".js-wish-delete").click(function() {
        var intID = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: $("#frmWishlist").attr("action"),
            data: { AJAXCALL: "Y", deleteID: intID }
        });

        $(this).parent().parent().remove();

        var count = $('#likeCount').attr('count');
        count = count - 1;
        if (count==0) {
            //            $('.flying-wish-list').css("display", "block");
            $('.flying-wish-list').fadeOut();
        }
        $('#likeCount').attr('count', count);
        $('#likeCount').html(count);
        $('.wishQuant').fadeOut();
        $('.wishQuant').html(count);
        $('.wishQuant').fadeIn();


        return false;
    });
});