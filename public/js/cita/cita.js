$(document).ready(function(){
    $.ajax({
        method: "POST",
        url: "../ajax/ajaxGetCitas",
        dataType: 'json',
        success: function (result) {
            console.log(result);
            var eventos;
            $('#mycalendar').monthly({
                mode: 'event',
                stylePast: true,
                dataType: 'json',
                events: eventos,
                weekStart: 'Mon'
            });
        }
    });
});