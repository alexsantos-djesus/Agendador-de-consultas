document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error("Elemento #calendar não encontrado.");
        return;
    }

    // Verifica se os campos hidden existem
    const dataConsulta = document.getElementById('data_consulta');
    const horaConsulta = document.getElementById('hora_consulta');

    if (!dataConsulta || !horaConsulta) {
        console.error("Campos hidden (data_consulta ou hora_consulta) não encontrados.");
        return;
    }

    try {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                // Exemplo de evento pré-carregado
                {
                    title: 'Consulta Marcada',
                    start: '2023-10-15T10:00:00',
                    end: '2023-10-15T11:00:00'
                }
            ],
            dateClick: function (info) {
    console.log("Data clicada:", info.dateStr);

    // Preencher os campos hidden
    const dataConsulta = document.getElementById('data_consulta');
    const horaConsulta = document.getElementById('hora_consulta');

    if (!dataConsulta || !horaConsulta) {
        console.error("Campos hidden não encontrados.");
        return;
    }

    dataConsulta.value = info.dateStr;
    horaConsulta.value = '10:00';

    // Abrir modal
    const modal = document.getElementById('modalAgendamento');
    if (!modal) {
        console.error("Modal #modalAgendamento não encontrado.");
        return;
    }

    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
}
        });

        calendar.render();
        console.log("FullCalendar inicializado");
    } catch (error) {
        console.error("Erro ao inicializar o FullCalendar:", error);
    }
        // Função para exibir o pop-up
        function showPopup(message) {
            const popupOverlay = document.getElementById('popupOverlay');
            const popupMessage = document.getElementById('popupMessage');

            popupMessage.textContent = message; // Define a mensagem
            popupOverlay.style.display = 'block'; // Exibe o pop-up
        }

        // Função para fechar o pop-up
        function closePopup() {
            const popupOverlay = document.getElementById('popupOverlay');
            popupOverlay.style.display = 'none'; // Oculta o pop-up
        }

        // Verifica se há uma mensagem de sucesso ou erro no URL (opcional)
        const urlParams = new URLSearchParams(window.location.search);
        const successMessage = urlParams.get('success');
        const errorMessage = urlParams.get('error');

        if (successMessage) {
            showPopup(successMessage); // Exibe o pop-up de sucesso
        } else if (errorMessage) {
            showPopup(errorMessage); // Exibe o pop-up de erro
        }
});