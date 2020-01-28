$(document).ready(function(){
    $(".submit").on("click", function(){
        $ciudad = $(".ciudad").val();
        $tipo = $(".tipo").val();
        $("#form_busqueda_home").attr("action", "home/busqueda/"+ciudad+"/"+tipo)
    });
});