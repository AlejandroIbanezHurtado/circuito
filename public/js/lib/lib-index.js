$(function(){
    var n_coches = $("#n_coches");
    var marcas = $("#cf-2");

    $.getJSON("/api/obtenIndex",function(result){
        console.log(result);
        n_coches.text(result.n_coches);
        for(i=0;i<result.marcas.length;i++)
        {
            op = $("<option>").text(result.marcas[i]);
            marcas.append(op);
        }
    })
})