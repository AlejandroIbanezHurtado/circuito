$(function(){
    var botonFinal = $("#btnPagarFinal");
    botonFinal.on("click",function(){
        $(".modal-body").after("<div class='progress'><div id='barra' class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>");
        $(".modal-body").remove();
        //Subir barra de progreso 1% cada milisegundo;
    })
})