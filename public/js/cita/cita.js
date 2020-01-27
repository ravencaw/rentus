$(document).ready(function(){
    var idUsuario = $("#idUsuario").val();

    $.ajax({
        method: "POST",
        url: "../ajax/ajaxGetCitas/"+idUsuario,
        dataType: 'json',
        data: {"idUsuario" : idUsuario},
        success: function (result) {

            var eventos = new Array();
            
            result.forEach(element => {
                var evento = new Object();
                var fechaHora = element.fechaHora.date.split(" ");

                evento.id=element.id;
                evento.name=element.direccion+" "+element.ciudad;
                evento.startdate=fechaHora[0];
                evento.starttime=fechaHora[1];
                evento.color="#FFB128";
                evento.url="/cita/show/"+element.id;

                eventos.push(evento);
            });

            var eventos_calendario = new Object();

            eventos_calendario.monthly=eventos;

            var eventos_json = JSON.stringify(eventos_calendario);
            eventos_json = JSON.parse(eventos_json);

            console.log(eventos_json);
            
            $('#mycalendar').monthly({
                mode: 'event',
                stylePast: true,
                dataType: 'json',
                events: eventos_json,
                weekStart: 'Mon'
            });
        }
    });
});