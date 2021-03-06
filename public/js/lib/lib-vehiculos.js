$(function(){
    var n_coches = $("#n_coches");
    var marcas = $("#cf-3");
    var tablon = $("#tablon");
    var spiner = $(".spinner-border");
    var paginacion = $("#paginacion");
    var imagenModal = $("#imagenModal");
    var tituloModal = $("#exampleModalLabel");
    var btnBuscar = $("#btnBuscar");
    

    $.getJSON("/api/obtenVehiculos",function(result){
        n_coches.text(result.n_coches);
        for(i=0;i<result.marcas.length;i++)
        {
            op = $("<option>").text(result.marcas[i].nombre).val(result.marcas[i].nombre).attr("id","marca_"+result.marcas[i].id);
            marcas.append(op);
        }

        spiner.remove();
        rellenar();
        paginacion.attr("pag",1);
        for(i=0;i<Math.ceil(parseInt(result.n_coches)/result.coches.length);i++)
        {
            elemento = $("<a class='page-link' value="+(i+1)+">"+(i+1)+"</a>");
            if(i==0) elemento.addClass("text-danger");
            paginacion.append(elemento);
            
            elemento.on("click",function(){
                paginacion.attr("pag",$(this).attr("value"));
                $(this).parent().children().removeClass("text-danger").addClass("text-dark");
                $(this).removeClass("text-dark").addClass("text-danger");
                if(btnBuscar.attr("buscar")==1)
                {
                    paginarFechas($(this).attr("value"));
                }
                else{
                    obtenPaginados($(this).attr("value"));
                }
                
            })
        }
    })

    btnBuscar.on("click",function(pagina, filas){
        ini = parseInt($("#cf-2").val().split(":")[0] + $("#cf-2").val().split(":")[1]);
        fin = parseInt($("#cf-5").val().split(":")[0] + $("#cf-5").val().split(":")[1]);
        if(($("#cf-2").val()==0 || $("#cf-5").val()==0) || (ini>=fin))
        {
            $("#modalHora").find(".modal-body").children().remove();
            $("#modalHora").find(".modal-body").append("<h2>Selecciona hora de inicio y hora de fin</h2>");
            $("#modalHora").find(".modal-body").append("<p>La hora de inicio debe ser menor que la hora de fin</p>");
            $("#modalHora").modal("show");
        }
        else{
            $(this).attr("buscar",1);
            paginarFechas();
        }
    })

    function paginarFechas(pagina=1, filas=6){
        vectorFecha = $("#dia").val().split("/");
        dia = vectorFecha[1];
        mes = vectorFecha[0];
        ano = vectorFecha[2];
    
        horaInicio = $("#cf-2").val();
        horaFin = $("#cf-5").val().split(":")[0];
        minutoFin = $("#cf-2").val().split(":")[1];
        if(minutoFin=="00")
        {
            minutoFin = "59";
            horaFin = parseInt(horaFin)-1;
        }
        else{
            minutoFin = parseInt(minutoFin)-1;
        }

    fechaInicio = ano+"-"+mes+"-"+dia+" "+horaInicio+":01";
    fechaFin = ano+"-"+mes+"-"+dia+" "+horaFin+":"+minutoFin+":59";
        if(marcas.val()==0)
        {
            marca=false;
        }
        else{
            marca = marcas.find("option[value="+marcas.val()+"]").attr("id").split("_")[1];
        }
        if($("#buscador").val()=="")
        {
            buscar = false;
        }
        else{
            buscar = $("#buscador").val();
        }

        if($("#cf-4").val()==0)
        {
            ordenar = false;
        }
        else{
            if($("#cf-4").val()=="asc")
            {
                ordenar = "asc";
            }
            else{
                ordenar = "desc";
            }
        }
        $.getJSON("/api/obtenVehiculosPaginadosNoFechas/"+fechaInicio+"/"+fechaFin+"/"+pagina+"/"+filas+"/"+marca+"/"+buscar+"/"+ordenar,function(result){
            tablon.children().remove();
            for(i=0;i<result.coches.length;i++)
            {
                cont = $("<div class='col-lg-4 col-md-6 mb-4' div='cajaVehiculos'></div>");
                item = $("<div class='item-1' id='coche_"+result.coches[i].id+"'></div>");
                ruta = "\"bd/"+result.coches[i].imagen+"\"";
                img = $("<a><div data-bs-toggle='modal' data-bs-target='#exampleModal' style='cursor:pointer; background-image: url("+ruta+"); width: 100%; background-size: 100%; background-repeat: no-repeat; background-position: center; height:170px'></div></a>");
                img.on("click",function(){
                    var bg = $(this).find("div").css('background-image');
                    bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
                    imagenModal.attr("src",bg);
                    tituloModal.text($(this).parent().parent().find("#tituloCarta").text());
                })
                itemCont = $("<div class='item-1-contents' style='height: 350px;''></div>");
                divCenter = $("<div class='text-center'></div>");//append titulo y precio

                titulo = $("<h2><a id='tituloCarta' class='text-danger'>"+result.coches[i].marca+" "+result.coches[i].modelo+"</a></h2>");
                precio = $("<div class='rent-price'><span>"+result.coches[i].precio+"???/</span>30m</div>");
                lista = $("<ul class='specs'></ul>");
                cv = $("<li><span>Potencia:</span><span class='spec'>"+result.coches[i].potencia+" CV</span></li>");
                cilindrada = $("<li><span>Cilindrada:</span><span class='spec'>"+result.coches[i].cilindrada+" cm3</span></li>");
                velocidad = $("<li><span>Velocidad.m??x:</span><span class='spec'>"+result.coches[i].velocidad+" km/h</span></li>");
                boton = $("<div class='d-flex action'><a class='btn btn-danger text-white'>Reservar</a></div>");
                boton.on("click",function(){
                    ini = parseInt($("#cf-2").val().split(":")[0] + $("#cf-2").val().split(":")[1]);
                    fin = parseInt($("#cf-5").val().split(":")[0] + $("#cf-5").val().split(":")[1]);
                    if(($("#cf-2").val()==0 || $("#cf-5").val()==0) || (ini>=fin))
                    {
                        $("#modalHora").find(".modal-body").children().remove();
                        $("#modalHora").find(".modal-body").append("<h2>Selecciona hora de inicio y hora de fin</h2>");
                        $("#modalHora").find(".modal-body").append("<p>La hora de inicio debe ser menor que la hora de fin</p>");
                        $("#modalHora").modal("show");
                    }
                    else{
                        horaInicio = $("#cf-2").val();
                        horaInicio = horaInicio.split(":");
                        fechaInicio = new Date($("#dia").val());
                        fechaInicio.setHours(horaInicio[0]);
                        fechaInicio.setMinutes(horaInicio[1]);

                        horaFin = $("#cf-5").val();
                        horaFin = horaFin.split(":");
                        fechaFin = new Date($("#dia").val());
                        fechaFin.setHours(horaFin[0]);
                        fechaFin.setMinutes(horaFin[1]);

                        rutaReserva = "reservar/coche/"+$(this).parent().parent().parent().parent().attr("id").split("_")[1]+"?inicio="+fechaInicio.getTime()+"&fin="+fechaFin.getTime();
                        window.location.href = rutaReserva;
                    }
                })

                cont.append(item.append(img).append(itemCont.append(divCenter.append(titulo).append(precio).append(lista.append(cv).append(cilindrada).append(velocidad).append(boton)))));
                tablon.append(cont);
            }
        })
    }
    

    function obtenPaginados(pagina, filas=6){
        rellenar(pagina,filas);
    }
    function rellenar(pagina=1, filas=6){
        $.getJSON("/api/obtenVehiculosPaginados/"+pagina+"/"+filas,function(result){
            tablon.children().remove();
            for(i=0;i<result.coches.length;i++)
            {
                cont = $("<div class='col-lg-4 col-md-6 mb-4' div='cajaVehiculos'></div>");
                item = $("<div class='item-1' id='coche_"+result.coches[i].id+"'></div>");
                ruta = "\"bd/"+result.coches[i].imagen+"\"";
                img = $("<a><div data-bs-toggle='modal' data-bs-target='#exampleModal' style='cursor:pointer; background-image: url("+ruta+"); width: 100%; background-size: 100%; background-repeat: no-repeat; background-position: center; height:170px'></div></a>");
                img.on("click",function(){
                    var bg = $(this).find("div").css('background-image');
                    bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
                    imagenModal.attr("src",bg);
                    tituloModal.text($(this).parent().parent().find("#tituloCarta").text());
                })
                itemCont = $("<div class='item-1-contents' style='height: 350px;''></div>");
                divCenter = $("<div class='text-center'></div>");//append titulo y precio
                
                titulo = $("<h2><a id='tituloCarta' class='text-danger'>"+result.coches[i].marca+" "+result.coches[i].modelo+"</a></h2>");
                precio = $("<div class='rent-price'><span>"+result.coches[i].precio+"???/</span>30m</div>");
                lista = $("<ul class='specs'></ul>");
                cv = $("<li><span>Potencia:</span><span class='spec'>"+result.coches[i].potencia+" CV</span></li>");
                cilindrada = $("<li><span>Cilindrada:</span><span class='spec'>"+result.coches[i].cilindrada+" cm3</span></li>");
                velocidad = $("<li><span>Velocidad.m??x:</span><span class='spec'>"+result.coches[i].velocidad+" km/h</span></li>");
                boton = $("<div class='d-flex action'><a class='btn btn-danger text-white'>Reservar</a></div>");
                boton.on("click",function(){
                    ini = parseInt($("#cf-2").val().split(":")[0] + $("#cf-2").val().split(":")[1]);
                    fin = parseInt($("#cf-5").val().split(":")[0] + $("#cf-5").val().split(":")[1]);
                    if(($("#cf-2").val()==0 || $("#cf-5").val()==0) || (ini>=fin))
                    {
                        $("#modalHora").find(".modal-body").children().remove();
                        $("#modalHora").find(".modal-body").append("<h2>Selecciona hora de inicio y hora de fin</h2>");
                        $("#modalHora").find(".modal-body").append("<p>La hora de inicio debe ser menor que la hora de fin</p>");
                        $("#modalHora").modal("show");
                    }
                    else{
                        horaInicio = $("#cf-2").val();
                        horaInicio = horaInicio.split(":");
                        fechaInicio = new Date($("#dia").val());
                        fechaInicio.setHours(horaInicio[0]);
                        fechaInicio.setMinutes(horaInicio[1]);

                        horaFin = $("#cf-5").val();
                        horaFin = horaFin.split(":");
                        fechaFin = new Date($("#dia").val());
                        fechaFin.setHours(horaFin[0]);
                        fechaFin.setMinutes(horaFin[1]);

                        rutaReserva = "reservar/coche/"+$(this).parent().parent().parent().parent().attr("id").split("_")[1]+"?inicio="+fechaInicio.getTime()+"&fin="+fechaFin.getTime();
                        window.location.href = rutaReserva;
                    }
                })

                cont.append(item.append(img).append(itemCont.append(divCenter.append(titulo).append(precio).append(lista.append(cv).append(cilindrada).append(velocidad).append(boton)))));
                tablon.append(cont);
            }
        })
    }

    $.getJSON("/api/dameFechaSesion",function(result){
        console.log(result);
        if(result.fecha!=null)
        {
            fecha = result.fecha.split(" ")[0].replaceAll("-","/");
            ini = result.fecha.split(" ")[1];
            $("#dia").datepicker("setDate",fecha);
            $("#cf-2").val(ini);
            if(ini.split(":")[1]="30")
            {
                fin = parseInt(ini.split(":")[0])+1 + ":00";
            }
            else{
                fin = ini.split(":")[0] +":30";
            }
            $("#cf-5").val(fin);

            if(result.marca!=null)
            {
                $("#cf-3 option[id=marca_"+result.marca+"]").attr("selected",true);
            }
            $("#btnBuscar").click();
        }
    })

    $("#circuito").on("click",function(){
        ini = parseInt($("#cf-2").val().split(":")[0] + $("#cf-2").val().split(":")[1]);
        fin = parseInt($("#cf-5").val().split(":")[0] + $("#cf-5").val().split(":")[1]);
        if(($("#cf-2").val()==0 || $("#cf-5").val()==0) || (ini>=fin))
        {
            $("#modalHora").find(".modal-body").children().remove();
            $("#modalHora").find(".modal-body").append("<h2>Selecciona hora de inicio y hora de fin</h2>");
            $("#modalHora").find(".modal-body").append("<p>La hora de inicio debe ser menor que la hora de fin</p>");
            $("#modalHora").modal("show");
        }
        else{
            horaInicio = $("#cf-2").val();
            horaInicio = horaInicio.split(":");
            fechaInicio = new Date($("#dia").val());
            fechaInicio.setHours(horaInicio[0]);
            fechaInicio.setMinutes(horaInicio[1]);

            horaFin = $("#cf-5").val();
            horaFin = horaFin.split(":");
            fechaFin = new Date($("#dia").val());
            fechaFin.setHours(horaFin[0]);
            fechaFin.setMinutes(horaFin[1]);

            rutaReserva = "reservar/circuito?inicio="+fechaInicio.getTime()+"&fin="+fechaFin.getTime();
            window.location.href = rutaReserva;
        }
    })
})