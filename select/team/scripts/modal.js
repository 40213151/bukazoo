$(function(){
    $(".chat-btn").on("click",function(){

        $("body").css({
            overflow : "hidden"
        });
        $("#modal-overlay").show();
        $("#modal").show();


    });

    $("#modal").find(".close").on("click",function(){

        $("body").css({
            overflow : "auto"
        });
        $("#modal-overlay").hide();
        $("#modal").hide();
    });
});
