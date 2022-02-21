$(function(){
    var botonFinal = $("#btnPagarFinal");
    botonFinal.on("click",function(){
        $(".modal-body").after("<div class='progress' id='contBarra'><div id='barra' class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: 0%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>");
        $(".modal-body").remove();
        for(i=0;i<=100;i++)
        {
            $("#barra").css("width",(i++)+"%");
        }
        
        setInterval(function(){
            $("#contBarra").after("<img src='/images/check.gif' alt='Check'>");
            $("#contBarra").remove();
        },1000);

        setInterval(function(){
            window.location.href="/misreservas";
        },2000)
    })

    vectorFecha = $("#dia").val().split("/");
    dia = vectorFecha[0];
    mes = vectorFecha[1];
    ano = vectorFecha[2];

    horaInicio = $("#horaInicio").val();
    horaFin = $("#horaFin").val();

    fechaInicio = ano+"-"+mes+"-"+dia+" "+horaInicio+":00";
    fechaFin = ano+"-"+mes+"-"+dia+" "+horaFin+":00";


    ids = [];
    $(".contenedorCoches").each(function(index,element){
        ids[index] = $(element).attr("id").split("_")[1];
    })

    console.log(ids);
    

    $.getJSON("/api/obtenVehiculosNoFechas/"+fechaInicio+"/"+fechaFin+"/"+"["+ids+"]",function(result){
        console.log(result);
        for(i=0;i<result.coches.length;i++)
        {
            $("#cf-2").append("<option value="+result.coches[i].id+">"+result.coches[i].marca +" "+result.coches[i].modelo+" - "+result.coches[i].precio+"€"+"</option>")
        }
    })
})