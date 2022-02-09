$(function(){
    $(".calendario").datepicker({
         minDate: 0,
         firstDay: 1,
         beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0), ''];
        }
        });
    $( ".calendario" ).datepicker( "option", "showAnim", "drop");

    $(".redes").on("click",function(){
        window.open($(this).attr("href"),'_blank');
    })

    $(".redes").mouseover(function(){
        $(this).css('cursor','pointer');
    })
})