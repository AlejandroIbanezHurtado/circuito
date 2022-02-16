$(function(){
    var n_coches = $("#n_coches");
    var marcas = $("#cf-3");
    var tablon = $("#tablon");
    var spiner = $("#spiner");

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
            img = $("<a href='bd/"+result.coches[i].modelo.imagen+"''><img src="+"bd/"+result.coches[i].modelo.imagen+" alt='Image' class='img-fluid'></a>");
            itemCont = $("<div class='item-1-contents'></div>");
            divCenter = $("<div class='text-center'></div>");//append titulo y precio
            titulo = $("<h3><a href='reservar/coche/"+result.coches[i].id+">"+result.coches[i].modelo.marca.nombre+" "+result.coches[i].modelo.nombre+"</a></h3>");
            precio = $("<div class='rent-price'><span>"+result.coches[i].precio+"€/30m</span>day</div>");
            lista = $("<ul class='specs'></ul>");
            cv = $("<li><span>CV:</span><span class='spec'>"+result.coches[i].modelo.cv+"</span></li>");
            cilindrada = $("<li><span>Cilindrada:</span><span class='spec'>"+result.coches[i].modelo.cilindrada+"</span></li>");
            velocidad = $("<li><span>Velocidad.máx:</span><span class='spec'>"+result.coches[i].modelo.velocidad+"</span></li>");
            boton = $("<div class='d-flex action'><a href='reservar/coche/"+result.coches[i].id+"' class='btn btn-danger'>Reservar</a></div>");

            cont.append(item.append(img).append(itemCont.append(divCenter.append(titulo).append(precio).append(lista.append(cv).append(cilindrada).append(velocidad).append(boton)))));
            tablon.append(cont);
            // $("<div class='col-lg-4 col-md-6 mb-4'><div class='item-1'><a href='#'><img src='images/img_1.jpg' alt='Image' class='img-fluid'></a><div class='item-1-contents'><div class='text-center'><h3><a href='#'>Range Rover S64 Coupe</a></h3><div class='rating'><span class='icon-star text-warning'></span><span class='icon-star text-warning'></span><span class='icon-star text-warning'></span><span class='icon-star text-warning'></span><span class='icon-star text-warning'></span></div><div class='rent-price'><span>$250/</span>day</div></div><ul class='specs'><li><span>Doors</span><span class='spec'>4</span></li><li><span>Seats</span><span class='spec'>5</span></li><li><span>Transmission</span><span class='spec'>Automatic</span></li><li><span>Minium age</span><span class='spec'>18 years</span></li></ul><div class='d-flex action'><a href='contact.html' class='btn btn-primary'>Rent Now</a></div></div></div></div>").appendTo(tablon);
        }

        
        
    })
})