$(function(){
    var guardar = $("#botonGuardar");
    var imagen = $("#imagen");
    var form = document.getElementById("formulario");

    guardar.on("click",function(){
        // $.ajax({
        //     type: "POST",
        //     url: '/api/editaUsuario',
        //     data: creaJson(),
        //     success: function(data){
        //     console.log(data);
        //     },
        //     error: function(xhr, status, error){
        //     console.error(xhr);
        //     }
        //    });
        $.post( "/api/editaUsuario", creaJson() );
    })

    function creaJson(){
        array = $(form).serializeArray();
        user = new usuario(array[0],array[1],array[2],imagen.attr("ruta"));
        return user;
    }
})
function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];
    var eliminar = $("#eliminarFoto");

    eliminar.on("click",function(){
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