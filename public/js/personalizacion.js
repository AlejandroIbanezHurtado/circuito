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
    $( ".calendario" ).datepicker({
        format:'mm/dd/yyyy',
    }).datepicker("setDate",'now');

    $(".redes").on("click",function(){
        window.open($(this).attr("href"),'_blank');
    })

    $(".redes").mouseover(function(){
        $(this).css('cursor','pointer');
    })

    $('.dropdown').hover(function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
      }, function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
      });
})