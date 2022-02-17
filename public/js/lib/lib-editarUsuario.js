$(function(){
    var guardar = $("#botonGuardar");
    var nombre = $("#inputFirstName");
    var apellidos = $("#inputLastName");

    guardar.on("click",function(){
        spinner = $("<div>").addClass("spinner-border text-danger").attr("id","cargando").attr("role","status").append($("span").addClass("sr-only").text("Loading..."));
        $("#carga").append(spinner);
        var formData = new FormData();
        var files = $('#file')[0].files[0];
        formData.append('file',files);
        formData.append('nombre',nombre.val());
        formData.append('apellidos',apellidos.val());
        $.ajax({
            url: '/api/editaUsuario',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            complete: function(){
                $("div").remove("#cargando");
            },
            success: function(response) {
                response = JSON.parse(response);
                if(response.length>0)
                {
                    $("div").remove(".cambios");
                    for(i=0;i<response.length;i++)
                    {
                        mensaje = $("<div>").addClass("alert alert-danger mt-3").attr("role","alert").text(response[i]).addClass("cambios");
                        $("#final").after(mensaje);
                    }
                }
                else{
                    $("div").remove(".cambios");
                    mensaje = $("<div>").addClass("alert alert-success mt-3").attr("role","alert").text("Los cambios se han guardado correctamente").addClass("cambios");
                    $("#final").after(mensaje);
                }
            },
            error: function(){
                $("div").remove(".cambios");
                mensaje = $("<div>").addClass("alert alert-danger mt-3").attr("role","alert").text("ERROR. Los cambios no se han podido guardar").addClass("cambios");
                $("#final").after(mensaje);
            }
        });
    })
})
function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];
    var eliminar = $("#eliminarFoto");

    eliminar.on("click",function(){
        $('#file')[0].files[0]=null;
        $("#imagen").attr("src", "http://localhost:8000/images/usuario.png").css("width", "128px");
    })

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            $("#imagen").attr("src", reader.result).css("width", "300px").attr("ruta",reader.result);
        }

        reader.readAsDataURL(file);
    }
}