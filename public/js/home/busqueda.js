$(document).ready(function () {
  $(".filter").on("change", function () {
    busquedaFiltros();
  });
  $(".filter").keypress(function(e) {
    if(e.which == 13) {
      busquedaFiltros();
    }
  });
});

function ajaxGetInmuebles(ciudad, tipo, precio_min, precio_max, superficie, precio_metro_cuadrado, zona, n_habitaciones, n_baños) {
  console.log(ciudad);
  $.ajax({
    method: "POST",
    url: "ajax/ajaxGetInmuebles",
    dataType: 'json',
    data: {
      "ciudad": ciudad,
      "tipo": tipo,
      "precio_min": (precio_min) ? precio_min : "",
      "precio_max": (precio_max) ? precio_max : "",
      "superficie": (superficie) ? superficie : "",
      "zona": (zona) ? zona : "",
      "n_habitaciones": (n_habitaciones) ? n_habitaciones : "",
      "n_baños": (n_baños) ? n_baños : ""
    },
    success: function (result) {

      $(".busqueda").empty();

      if (result.length > 0) {
        $(".busqueda").append("<div id='wrapper' class='container col-md-12' style='margin: 0px; margin-bottom:20%;color: rgb(0,0,0);background-color: rgba(39,104,104,0);'>" +
        "<div id='#sidebar-wrapper' class='col-md-2' style='color: rgb(0,0,0);padding: 0px;background-color: rgba(39,104,104,0);'>" +
          "<div id='sidebar-wrapper' style='background-color: rgb(39,104,104);color: rgb(0,0,0);text-align:left;'>" +
          "<form method='post' id='filtro_form'>" +
          "<ul class='sidebar-nav'>" +
          "<li>" +
          "Precio<br>" +
          "<input type='number' class='form-control col-md-12 filter' id='precio_min' placeholder='Precio mínimo'>" +
          "<input type='number' class='form-control col-md-12 filter' id='precio_max'  style='margin-top:10px;' placeholder='Precio máximo'>" +
          "</li>" +

          "<li>" +
          "Superficie" +
          "<input type='number' class='form-control col-md-12 filter' id='superficie'>" +
          "</li>" +
          "<li>" +
          "Zona" +
          "<select id='zona' class='form-control filter'>" +
          "<option value='0'>Seleccione una zona...</option>" +
          "<option value='centro'>Centro</option>" +
          "<option value='cerca_centro'>Cerca del centro</option>" +
          "<option value='periferia'>Periferia</option>" +
          "<option value='extrarradio'>Extrarradio</option>" +
          "<option value='afueras'>Afueras</option>" +
          "</select>" +
          "</li>" +
          "<li>" +
          "Nº de habitaciones " +
          "<input type='number' class='form-control col-md-12 filter' id='n_habitaciones'>" +
          "</li>" +
          "<li>" +
          "Nº de baños" +
          "<input type='number' class='form-control col-md-12 filter' id='n_baños'>" +
          "</li>" +
          "</ul>" +
          "</form>" +
          "</div>" +
          "</div>" +
          "<div class='resultados'></div></div>");
        result.forEach(element => {
          var html = "<div class='card mb-3 col-md-12'>" +
            "<a href='resultado/" + element.id + "'>" +
            "<div class='row no-gutters'>";
          console.log(element);
            if(element.foto){
              html+="<div class='col-md-4'>" +
              "<img src='../img/inmuebles/"+element.foto[element.id].idInmueble+"/"+element.foto[element.id].ruta+"' class='card-img'  style='max-width: 800px;'/>" +
              "</div>";
            }else{
              html+="<div class='col-md-4'>" +
              "<img src='../img/no_image.jpg' class='card-img'  style='max-width: 800px;'/>" +
              "</div>";
            }
            html += "<div class='col-md-8'>" +
            "<div class='card-body'>" +
            "<h5 class='card-title'>" + element.direccion + "</h5>" +
            "<p class='card-text'>Precio:" + element.precio + "€</p>" +
            "<p class='card-text'>" + element.ciudad + " " + element.cp + "</p>" +
            "<p class='card-text'><small class='text-muted'>" + element.superficie + " m<sup>2</sup> - " + Math.round((element.precio / element.superficie), 2) + " €/m<sup>2</sup></small></p>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</a>" +
            "</div>";
            $(".resultados").append(html);
        });

        $(".filter").on("change", function () {
          busquedaFiltros();
        });
      } else {
        $(".busqueda").append("<span align='center'>No se han encontrado registros</span>");
      }
    }
  });
}

function busquedaFiltros() {
  $ciudad = $("#ciudad").val();
  $tipo = $("#tipo").val();
  $precio_min = $("#precio_min").val();
  $precio_max = $("#precio_max").val();
  $superficie = $("#superficie").val();
  $zona = $("#zona").val();
  $n_habitaciones = $("#n_habitaciones").val();
  $n_baños = $("#n_baños").val();

  ajaxGetInmuebles($ciudad, $tipo, $precio_min, $precio_max, $superficie, $zona, $n_habitaciones, $n_baños);
}