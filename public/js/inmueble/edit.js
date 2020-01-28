contador = 1;

$(document).ready(function(){
    $("#anyadirFoto").on("click", function(){
        $("#imagenes").append("<br><input type='file' name='foto"+contador+"'><br>");
        contador++;
    });

});