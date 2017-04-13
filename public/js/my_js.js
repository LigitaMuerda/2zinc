$( document ).ready(function() {
// open_list
    $(function(){
        $(".open_con").on("click",function(){
            var id = $(this).attr("data");
            if ( $(this).hasClass("active") ) {
                $(this).removeClass("active");
                //$(id).animate({"height": "0px"}, 300);
                $(id).css({"margin-bottom": "4px"});
                //$(id).find(".open_list").animate({"margin-top": "-300px"}, 300);
                $(id).slideUp();
            }
            else
            {
                $(this).addClass("active");
                /*$(id).css({"height": "auto"});
                setTimeout (function(){
                    $(id).css({"margin-bottom": "0px"});
                }, 200);
                $(id).find(".open_list").animate({"margin-top": "-0px"}, 300);*/
                 $(id).slideDown();
            }
            return false;
        });
    });

});

