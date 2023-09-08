//https://fullcalendar.io/docs/initialize-globals
//https://www.unidadvirtual.com/fullcalendar-implementar-plugin-de-jquery

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    debugger
    // Inicializamos el calendario
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        dateClick: function() {
            alert('a day has been clicked!');
        }
    });

    // Renderizamos el calendario
    calendar.render();
});





//https://programacion.net/articulo/como_integrar_el_plugin_fullcalendar_de_jquery_con_bootstrap-_php_y_mysql_1679
