<!-- calendario.php -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Calendário de Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
</head>

<body>
    <div class="container mt-5 modal-body">
        <h2 class="text-center mb-4">Calendário de Agendamentos</h2>
        <div id="calendar"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                events: '/Agendador-de-consultas/ajax/listar_eventos.php' // criar esse endpoint
            });
            calendar.render();
        });
    </script>
</body>

</html>