$(function(){
    var n_coches = $("#n_coches");
    var marcas = $("#cf-3");
    var tablon = $("#tablon");
    var spiner = $(".spinner-border");
    var anterior = $("#anterior");

    $.getJSON("/api/obtenVehiculos",function(result){
        console.log(result);
        n_coches.text(result.n_coches);
        for(i=0;i<result.marcas.length;i++)
        {
            op = $("<option>").text(result.marcas[i]).val(result.marcas[i]);
            marcas.append(op);
        }

        spiner.remove();
        for(i=0;i<result.coches.length;i++)
        {
            cont = $("<div class='col-lg-4 col-md-6 mb-4'></div>");
            item = $("<div class='item-1'></div>");
            ruta = "\"bd/"+result.coches[i].imagen+"\"";
            img = $("<a href='bd/"+result.coches[i].imagen+"''><div style='background-image: url("+ruta+"); width: 100%; background-size: 100%; background-repeat: no-repeat; background-position: center; height:170px'></div></a>");
            itemCont = $("<div class='item-1-contents' style='height: 350px;''></div>");
            divCenter = $("<div class='text-center'></div>");//append titulo y precio
            titulo = $("<h2><a class='text-danger' href='reservar/coche/"+result.coches[i].id+"'>"+result.coches[i].marca+" "+result.coches[i].modelo+"</a></h2>");
            precio = $("<div class='rent-price'><span>"+result.coches[i].precio+"€/</span>30m</div>");
            lista = $("<ul class='specs'></ul>");
            cv = $("<li><span>Potencia:</span><span class='spec'>"+result.coches[i].potencia+" CV</span></li>");
            cilindrada = $("<li><span>Cilindrada:</span><span class='spec'>"+result.coches[i].cilindrada+" cm3</span></li>");
            velocidad = $("<li><span>Velocidad.máx:</span><span class='spec'>"+result.coches[i].velocidad+" km/h</span></li>");
            boton = $("<div class='d-flex action'><a href='reservar/coche/"+result.coches[i].id+"' class='btn btn-danger'>Reservar</a></div>");

            cont.append(item.append(img).append(itemCont.append(divCenter.append(titulo).append(precio).append(lista.append(cv).append(cilindrada).append(velocidad).append(boton)))));
            tablon.append(cont);
        }
        for(i=0;i<Math.trunc(parseInt(result.n_coches)/result.coches.length);i++)
        {
            anterior.append($("<a class='page-link' href='obtenPaginados("+(i+1)+")'>"+(i+1)+"</a>"));
        }

        
        
    })

    function obtenPaginados(pagina){
        alert(pagina);
    }
})