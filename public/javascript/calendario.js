//https://fullcalendar.io/docs/initialize-globals
//https://www.unidadvirtual.com/fullcalendar-implementar-plugin-de-jquery

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    // Inicializamos el calendario
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        dateClick: function() {
            alert('a day has been clicked!');
        },
        headerToolbar: { center: 'dayGridMonth,timeGridWeek' }, 

        views: {
            dayGrid: {
                // options apply to dayGridMonth, dayGridWeek, and dayGridDay views
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            timeGrid: {
                // options apply to timeGridWeek and timeGridDay views
            },
            week: {
                // options apply to dayGridWeek and timeGridWeek views
            },
            day: {
                // options apply to dayGridDay and timeGridDay views
            }
        },
        events: [
            {
                title: 'Mi evento 1',
                start: '2023-09-23',
                end: '2023-09-24'
            },
            {
                title: 'Mi evento 2',
                start: '2023-09-25'
            }
        ]
    });

    // Renderizamos el calendario
    calendar.render();

    calendar.setOption('locale', 'es');

});





//https://programacion.net/articulo/como_integrar_el_plugin_fullcalendar_de_jquery_con_bootstrap-_php_y_mysql_1679
