$(function(){
    var botonFinal = $("#btnPagarFinal");
    var botonPagar = $("#btnPagar");

    vectorFecha = $("#dia").val().split("/");
    dia = vectorFecha[0];
    mes = vectorFecha[1];
    ano = vectorFecha[2];

    horaInicio = $("#horaInicio").val();
    horaFin = $("#horaFin").val().split(":")[0];
    minutoFin = $("#horaFin").val().split(":")[1];
    if(minutoFin=="00")
    {
        minutoFin = "59";
        horaFin = parseInt(horaFin)-1;
    }
    else{
        minutoFin = parseInt(minutoFin)-1;
    }

    var fechaInicio = ano+"-"+mes+"-"+dia+" "+horaInicio+":01";
    var fechaFin = ano+"-"+mes+"-"+dia+" "+horaFin+":"+minutoFin+":59";


    botonPagar.on("click",function(){
        botonFinal.find("span").text("Pagar "+$("#total").attr("value")+"€");
    })

    botonFinal.on("click",function(){
        ids = [];
        $(".contenedorCoches").each(function(index,element){
            ids[index] = $(element).attr("id").split("_")[1];
        })
        pTotal = $("#total").attr("value");
        $.ajax({
            url: "/api/hacerReserva/["+ids+"]/"+pTotal+"/"+fechaInicio+"/"+fechaFin,
            type: 'post',
            contentType: false,
            processData: false,
            complete: function(){
                $("div").remove("#cargando");
            },
            success: function() {
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
            },
            error: function(){
                $(".modal-body").after("<div class='alert alert-danger' role='alert'>Error, no se ha podido realizar la reserva</div>");
                $(".modal-body").remove();
            }
        });
    })

    
    rellenaMarcas(fechaInicio,fechaFin);

    $("#cf-2").on("change",function(){
        id_coche = $(this).val();
        $.getJSON("/api/obtenVehiculo/"+id_coche,function(result){
            let tramo = $("#filtro").attr("data-tramo");
            cont = $("<div id=coche_"+result.id+" class='contenedorCoches my-5'></div>");
            fila1 = $("<div class='row align-items-center mb-4'></div>");
            col1 = $("<div class='col-md-6'><h1 class='m-0'>"+result.marca+""+result.modelo+"</h1></div>");
            fila2 = $("<div class='row'></div>");
            col2 = $("<div class='col-lg-6'></div>");
            img = $("<div style='background-image: url(/bd/"+result.imagen+"); width: 100%; background-size: 70%; background-repeat: no-repeat; background-position: center; height:210px'></div>");
            col3 = $("<div class='col-lg-4'><p>Potencia: "+result.potencia+" CV</p><p>Cilindrada: "+result.cilindrada+" cm3</p><p>Velocidad máxima: "+result.velocidad+" km/h</p><p class='precio' value="+result.precio*tramo+">Precio: "+result.precio*tramo+"€</p></div>");
            col4 = $("<div class='col-lg-2'><button class='btn btn-danger align-middle text-white eliminar'>Eliminar</button></div>");
            cont.append(fila1.append(col1)).append(fila2.append(col2.append(img)).append(col3).append(col4));
            $(document).on("click",".eliminar",function(){
                $(this).parent().parent().parent().remove();
                rellenaMarcas(fechaInicio,fechaFin);
                rellenaTotal();
            })
            $("#ultimafila").before(cont);
            rellenaMarcas(fechaInicio,fechaFin);
            rellenaTotal();
        })
    })


    function rellenaMarcas(fechaInicio,fechaFin)
    {
        ids = [];
        $(".contenedorCoches").each(function(index,element){
            ids[index] = $(element).attr("id").split("_")[1];
        })

        $.getJSON("/api/obtenVehiculosNoFechas/"+fechaInicio+"/"+fechaFin+"/"+"["+ids+"]",function(result){
            $("#cf-2").empty();
            $("#cf-2").append("<option value='0'>-Añadir otro coche-</option>")
            for(i=0;i<result.coches.length;i++)
            {
                $("#cf-2").append("<option value="+result.coches[i].id+">"+result.coches[i].marca +" "+result.coches[i].modelo+" - "+result.coches[i].precio+"€"+"</option>")
            }
        })
    }

    function rellenaTotal()
    {
        total = 0;
        $(".precio").each(function(index,element){
            total = total + parseInt($(element).attr("value"));
        })
        $("#total").text("Precio total: "+total+"€").attr("value",total);
    }
})