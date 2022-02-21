$(function(){
    var cajaPrinci = $("#contPrinci");
    $.getJSON("/api/obtenMisReservas",function(result){
        console.log(result);
        for(i=0;i<result.length;i++)
        {
            cajaPrinci.append("<h2>"+result[i].marca+" "+result[i].modelo+"</h2>")
        }
    })
})