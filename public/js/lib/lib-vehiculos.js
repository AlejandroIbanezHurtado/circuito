$(function(){
    var n_coches = $("#n_coches");
    var marcas = $("#cf-3");
    var tablon = $("#tablon");
    var spiner = $(".spinner-border");
    var paginacion = $("#paginacion");
    // var siguiente = $("#siguiente");
    // var anterior = $("#anterior");

    $.getJSON("/api/obtenVehiculos",function(result){
        console.log(result);
        n_coches.text(result.n_coches);
        for(i=0;i<result.marcas.length;i++)
        {
            op = $("<option>").text(result.marcas[i]).val(result.marcas[i]);
            marcas.append(op);
        }

        spiner.remove();
        rellenar();
        paginacion.attr("pag",1);
        for(i=0;i<Math.ceil(parseInt(result.n_coches)/result.coches.length);i++)
        {
            elemento = $("<a class='page-link' value="+(i+1)+">"+(i+1)+"</a>");
            paginacion.append(elemento);
            
            elemento.on("click",function(){
                paginacion.attr("pag",$(this).attr("value"));
                $(this).parent().children().removeClass("text-danger").addClass("text-dark");
                $(this).removeClass("text-dark").addClass("text-danger");
                obtenPaginados($(this).attr("value"));
            })
        }
        n = parseInt(paginacion.attr("pag"));
        // siguiente.on("click",function(){
        //     if(n<$(this).parent().children().length-2)
        //     {
        //         paginacion.attr("pag",n+1);
        //         rellenar(parseInt(paginacion.attr("pag")),6);
        //     }
            
        // })
        // anterior.on("click",function(){
        //     alert(paginacion.attr("pag"))
        //     if(n>0)
        //     {
        //         paginacion.attr("pag",n-1);
        //         rellenar(parseInt(paginacion.attr("pag")),6);
                
        //     }
        // })
        
    })

    modal = $("<div id='ex1' class='modal'><p>Thanks for clicking. That felt good.</p><a href='#' rel='modal:close'>Close</a></div>");
    $("body").append(modal);



    function obtenPaginados(pagina, filas=6){
        rellenar(pagina,filas);
    }
    function rellenar(pagina=1, filas=6){
        $.getJSON("/api/obtenVehiculosPaginados/"+pagina+"/"+filas,function(result){
            tablon.children().remove();
            for(i=0;i<result.coches.length;i++)
            {
                cont = $("<div class='col-lg-4 col-md-6 mb-4' div='cajaVehiculos'></div>");
                item = $("<div class='item-1'></div>");
                ruta = "\"bd/"+result.coches[i].imagen+"\"";
                img = $("<a href='#ex1' rel='modal:open'><div style='background-image: url("+ruta+"); width: 100%; background-size: 100%; background-repeat: no-repeat; background-position: center; height:170px'></div></a>");
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
        })
    }
})