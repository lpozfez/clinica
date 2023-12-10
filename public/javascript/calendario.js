document.addEventListener('DOMContentLoaded', function () {

    
    const calendarEl = document.getElementById('calendar');
    

    // Inicializamos el calendario
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true, // Permitir selección
        select: function (info) {

            // Por ejemplo, puedes mostrar un cuadro de diálogo para elegir la hora
            const selectedTime = prompt('Selecciona la hora para la cita (HH:mm):', '12:00');
            
            if (selectedTime) {// info.start y info.end representan el rango de tiempo seleccionado
                const startTime = info.startStr.split('T')[0] + 'T' + selectedTime;
                const endTime = info.endStr.split('T')[0] + 'T' + selectedTime;

                // Agregamos el evento
                calendar.addEvent({
                    title: 'Nueva cita',
                    start: startTime,
                    end: endTime,
                    allDay: false // Esto indica que no es un evento de todo el día
                });
            }

            calendar.unselect();
        },
        headerToolbar: { center: 'dayGridMonth,timeGridWeek' },
        views: {
            dayGrid: {
                titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
            },
            timeGrid: {},
            week: {},
            day: {}
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
