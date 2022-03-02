$(function(){
    var botonFinal = $("#btnPagarFinal");
    var botonPagar = $("#btnPagar");
    var comentar = $("#comentar");
    var botonPublicar = $("#publicar");

    $("input[name='rating']").on("click",function(){
        $("#puntuacion").attr("puntuacion",$(this).attr("value"));
    })

    botonPublicar.on("click",function(){
        val = $("#puntuacion").attr("puntuacion");
        if(val=="0")
        {
            alert("Selecciona tu valoracion pulsando en las estrellas");
        }
        else{
            $.post("/api/insertaComentario",
            {
              comentario: $("#ctext").val(),
              valoracion: $("#puntuacion").attr("puntuacion"),
              coche: $(".contenedorCoches").first().attr("id").split("_")[1]
            },
            function(){
                $("fieldset").children().slice(1).remove();
                muestraComentarios();
            });
        }
        
    })

    $("#commentForm").validate({
        rules: {
          ctext: {
            maxlength: 300
          }
        },
        messages: {
            ctext: {
              maxlength: "Máximo 300 caracteres!"
            }
          }
      });

      $("#modalTarjeta").validate({
        rules: {
          titular: {
            required : true,
            maxlength: 35
          },
          tarjeta: {
            maxlength: 18,
            minlength: 13
          },
          fecha: {
            required : true,
            date : true
          },
          cvv: {
            maxlength: 3,
            minlength: 3
          }
        },
        messages: {
            titular: {
              maxlength: "Máximo 35 caracteres!",
              required: "Este campo es obligatorio"
            },
            tarjeta: {
                maxlength: "Máximo 18 caracteres!",
                minlength: "Mínimo 13 caracteres"
              },
              fecha: {
                date: "Fecha incorrecta",
                required: "Este campo es obligatorio"
              },
              cvv: {
                maxlength: "Máximo 3 caracteres!",
                required: "Mínimo 3 caracteres"
              }
          }
      });

    // muestraComentarios();
    function muestraComentarios()
    {
        id = $(".contenedorCoches").attr("id").split("_")[1];
        $.getJSON("/api/obtenComentarios/"+id,function(result){
            for(j=0;j<result.length;j++)
            {
                console.log(result);
                carta = $("<div class='card'></div>");
                fila = $("<div class='row'></div>");
                src = "/images/usuario.png";
                if(result[j].imagen!=null) src="/"+result[j].imagen;
                img = $("<div class='col-2'> <img src="+src+" width='70' class='rounded-circle mt-2'> </div>");
                col = $("<div class='col-10'></div>");
                contCom = $("<div class='comment-box ml-2'></div>");
                user = $("<h4>"+result[j].nombre+" "+result[j].apellidos+"</h4>");
                estrellas = $("<div class='rating'></div>");
                for(i=0;i<parseInt(result[j].valoracion);i++)
                {
                    estrellas.append($("<i class='bi bi-star text-warning my-4'></i>"));
                }
                col.append(contCom.append(user).append(estrellas));
                com = $("<div class='comment-area'> <textarea readonly class='form-control' rows='4'>"+result[j].comentario+"</textarea> </div>");
                if(result[j].comentario!=null && result[j].comentario!="") col.append(com);
                carta.append(fila.append(img).append(col));
                comentar.after(carta);
            }
            
        })
    }

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
    var ini =  ano+"-"+mes+"-"+dia+" "+horaInicio+":00";
    var fin =  ano+"-"+mes+"-"+dia+" "+horaFin+":00";
    var fechaInicio = ano+"-"+mes+"-"+dia+" "+horaInicio+":01";
    var fechaFin = ano+"-"+mes+"-"+dia+" "+horaFin+":"+minutoFin+":59";

    botonFinal.on("click",function(){
        pTotal = $("#total").attr("value");
        $.ajax({
            url: "/api/hacerReservaCircuito/"+pTotal+"/"+ini+"/"+fin,
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
})