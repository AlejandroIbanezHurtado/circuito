$(function(){
    var cajaPrinci = $("#contPrinci");
    $.getJSON("/api/obtenMisReservas",function(result){
        console.log(result);
        $("#spinner").remove();
        for(i=0;i<result.length;i++)
        {
            contenedor = $("<div id='coche_"+result[i].id+"' class='contenedorCoches my-5'></div>")
            tituloPrinci = $("<div class='row align-items-center mb-4 ml-5'></div>");
            titulo = $("<div class='col-md-6'><h1 class='m-0'>"+result[i].marca+" "+result[i].modelo+"</h1><div>");
            fila = $("<div class='row'></div>");
            imagen = $("<div class='col-lg-6'><div style='background-image: url(/bd/"+result[i].imagen+"); width: 100%; background-size: 70%; background-repeat: no-repeat; background-position: center; height:210px'></div></div>");
            datos = $("<div class='col-lg-4'><p>Se reservó el día: "+result[i].fecha+"</p><p>Fecha de inicio: "+result[i].fecha_inicio+"</p><p>Fecha de fin: "+result[i].fecha_fin+"</p><h4>Precio: "+result[i].precio+"€</h4></div>");
            botonCancelar = $("<div class='col-lg-2'><input type='button' value='Cancelar' data-bs-toggle='modal' data-bs-target='#exampleModal' class='btn btn-danger'></div>");
            cajaPrinci.append(contenedor.append(tituloPrinci.append(titulo)).append(fila.append(imagen).append(datos).append(botonCancelar)));        
        }
    })
})