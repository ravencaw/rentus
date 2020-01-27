$(document).ready(function(){
    $(".filter").on("change", function(){
        var $tipo = $("#tipo").val();
        var $precio_min = $("#precio_min").val();
        var $precio_max = $("#precio_max").val();
        var $precio_metro_cuadrado = $("#precio_metro_cuadrado").val();
        var $superficie = $("#superficie").val();
        var $zona = $("#zona").val();
        var $n_habitaciones = $("#n_habitaciones").val();
        var $n_baños = $("#n_baños").val();

        ajaxGetInmuebles($tipo, $precio_min, $precio_max, $superficie, $precio_metro_cuadrado, $zona, $n_habitaciones, $n_baños);
    });
});

function ajaxGetInmuebles(tipo, precio_min, precio_max, superficie, precio_metro_cuadrado, zona, n_habitaciones, n_baños){
        
        $.ajax({
          method: "POST",
          url: "ajax/ajaxGetInmuebles",
          dataType: 'json',
          data: {
              "tipo": tipo,
              "precio_min": precio_min,
              "precio_max": precio_max,
              "superficie": superficie,
              "precio_metro_cuadrado": precio_metro_cuadrado,
              "zona": zona,
              "n_habitaciones": n_habitaciones,
              "n_baños": n_baños
            },
          success: function (result) {
              console.log(result);
          }
        });
      }