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
              $(".resultados").empty();
              result.forEach(element => {
                $(".resultados").append("<div class='card mb-3 col-md-12'>"+
                "<a href='resultado/"+element.id+"'>"+
                    "<div class='row no-gutters'>"+
                        "<div class='col-md-4'>"+
                                "<img src='../public/img/no_image.jpg' class='card-img'/>"+
                        "</div>"+
                        "<div class='col-md-8'>"+
                            "<div class='card-body'>"+
                                "<h5 class='card-title'>"+element.direccion+"</h5>"+
                                "<p class='card-text'>Precio:"+ element.precio+ "€</p>"+
                                "<p class='card-text'>"+element.ciudad+" "+ element.cp +"</p>"+
                                "<p class='card-text'><small class='text-muted'>"+ element.superficie +" m<sup>2</sup> - "+Math.round((element.precio/element.superficie), 2)+" €/m<sup>2</sup></small></p>"+
                            "</div>"+
                        "</div>"+
                     "</div>"+
                 "</a>"+
            "</div>");
              });
          }
        });
      }