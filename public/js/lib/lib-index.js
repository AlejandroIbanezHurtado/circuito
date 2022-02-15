$(function(){
    var n_coches = $("#n_coches");
    var marcas = $("#cf-3");
    var carrusel = $("#carrusel");
    var spiner = $("#spiner");
    var comentarios = $(".comentario");

    $.getJSON("/api/obtenIndex",function(result){
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
            carrusel_item = $("<div>").addClass("carousel-item");
            if(i==0) carrusel_item.addClass("active");
            card = $("<div>").addClass("card w-80 rounded").css("width","25rem");
            img = $("<img>").attr("src","bd/"+result.coches[i].imagen);
            valoracion = $("<div>").addClass("ratings text-center");
            for(j=0;j<result.coches[i].media;j++)
            {
                valoracion.append($("<i class='bi bi-star text-warning'></i>"));
            }
            card_body = $("<div>").addClass("card-body");
            titulo = $("<h5>").addClass("card-title text-center").text(result.coches[i].marca);
            texto = $("<p>").addClass("card-text text-center").text(result.coches[i].modelo);
            precio = $("<h3>").addClass("card-text").text(result.coches[i].precio+"€");
            boton = $("<button>").addClass("btn btn-danger").text("Reservar");
            cuerpo = carrusel_item.append(card.append(img).append(card_body.append(titulo).append(valoracion).append(texto).append(precio).append(boton)));
            carrusel.append(cuerpo);
        }

        $(".spinner-border").remove();
        comentarios.each(function(index, element){
            $(element).find("p").text(result.comentarios[index].comentario);
            $(element).find("span").text(result.comentarios[index].nombre+" "+result.comentarios[index].apellidos);
            if(result.comentarios[index].imagen!=null) $(element).find("img").attr("src",result.comentarios[index].imagen);
            valoracion = $("<div>").addClass("ratings text-center");
            for(j=0;j<result.comentarios[index].valoracion;j++)
            {
                valoracion.append($("<i class='bi bi-star text-warning'></i>"));
            }
            $(element).find(".d-flex").after(valoracion);
        })
        
    })
})