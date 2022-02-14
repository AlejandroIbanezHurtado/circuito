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
                $("div").remove(".cambios");
                mensaje = $("<div>").addClass("alert alert-success mt-3").attr("role","alert").text("Los cambios se han guardado correctamente").addClass("cambios");
                $("#final").after(mensaje);

                //recojer en response los errores y listarlos en rojo
            },
            error: function(){
                $("div").remove(".cambios");
                mensaje = $("<div>").addClass("alert alert-success mt-3").attr("role","alert").text("Los cambios se han guardado correctamente").addClass("cambios");
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