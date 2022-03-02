$(function(){
    var cajaPrinci = $("#contPrinci");
    $.getJSON("/api/obtenMisReservas",function(result){
        console.log(result);
        $("#spinner").remove();
        for(i=0;i<result.length;i++)
        {
            if(result[i].id==null)
            {
                result[i].marca = "Circuito";
                result[i].modelo = "";
                result[i].imagen = "../images/circuito.jpg";
                result[i].id = result[i].reserva_id;
            }
            contenedor = $("<div id='coche_"+result[i].id+"' class='contenedorCoches my-5'></div>");
            if(result[i].id==null) contenedor.attr("circuito","true");
            tituloPrinci = $("<div class='row align-items-center mb-4 ml-5'></div>");
            titulo = $("<div class='col-md-6'><h1 class='m-0'>"+result[i].marca+" "+result[i].modelo+"</h1><div>");
            fila = $("<div class='row'></div>");
            imagen = $("<div class='col-md-6 col-sm-6 col-6'><div style='background-image: url(/bd/"+result[i].imagen+"); width: 100%; background-size: 70%; background-repeat: no-repeat; background-position: center; height:210px'></div></div>");
            datos = $("<div class='col-md-4 col-sm-4 col-4'><p>Se reservó el día: "+result[i].fecha+"</p><p>Fecha de inicio: "+result[i].fecha_inicio+"</p><p>Fecha de fin: "+result[i].fecha_fin+"</p><h4>Precio individual: "+result[i].precio+"€</h4>Precio conjunto: "+result[i].precio+"€</h4></div>");
            botonCancelar = $("<div class='col-md-2 col-sm-2 col-2' data-bs-toggle='modal' data-bs-target='#modalHora'><input type='button' value='Cancelar' class='btn btn-danger'></div>");
            cajaPrinci.append(contenedor.append(tituloPrinci.append(titulo)).append(fila.append(imagen).append(datos)));
            actual = new Date();
            ini = new Date(result[i].fecha_inicio);
            if(actual<ini) fila.append(botonCancelar);
            botonCancelar.find("input[type='button']").on("click",function(){
                id_coche = $(this).parent().parent().parent().attr("id").split("_")[1];
                circuito = $(this).parent().parent().parent().attr("circuito");
                $("#btnCancelar").on("click",function(){
                    if(circuito=="true")
                    {
                        $.get("/api/borraReservaCircuito/"+id_coche,function(data){
                            $(document).find("div[id=coche_"+id_coche+"]").remove();
                        })
                    }
                    else
                    {
                        $.get("/api/borraReserva/"+id_coche,function(data){
                            $(document).find("div[id=coche_"+id_coche+"]").remove();
                        })
                    }
                    
                })
            })        
        }
    })
})