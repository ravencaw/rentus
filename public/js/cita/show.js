$(document).ready(function(){
    ajaxGetLocalizacion();
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
  
  function ajaxGetLocalizacion(){
    var id = parseInt($("#id").html());
      
      $.ajax({
        method: "POST",
        url: "../ajax/ajaxGetLocalizacion/"+id,
        dataType: 'json',
        data: {"id": id},
        success: function (result) {
          initMap(result.longitud, result.latitud, result.direccion);
        }
      });
    }