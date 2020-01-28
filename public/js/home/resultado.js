$(document).ready(function(){
  ajaxGetLocaclizacion();
  $(window).resize(function(){
    if($(window).width() < 769){
      $("#tarjeta_slider").removeClass("d-inline-flex");
    }
    if($(window).width() > 769){
      $("#tarjeta_slider").addClass("d-inline-flex");
    }
  });
  
});

function initMap(longitud, latitud, direccion) {
    var latLng = new google.maps.LatLng(latitud, longitud);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latLng,
      zoom: 20
    });

    var infowindow = new google.maps.InfoWindow({
      content: direccion
    });
  
    
    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      title: direccion
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });
  

    marker.setMap(map);

  
    var infoWindow = new google.maps.InfoWindow;
    
}

function ajaxGetLocaclizacion(){
var idInmueble = parseInt($("#idInmueble").val());
    
    $.ajax({
      method: "POST",
      url: "../ajax/ajaxGetLocalizacion/"+idInmueble,
      dataType: 'json',
      data: {"idInmueble": idInmueble},
      success: function (result) {
        initMap(result.longitud, result.latitud, result.direccion);
      }
    });
  }