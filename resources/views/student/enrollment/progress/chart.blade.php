<canvas id="myChart" width="400" height="200"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var ctx = document.getElementById('myChart').getContext('2d');

        // Crea un gráfico de barras
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [   'Completed ({{$viewData->sessionsBag()->completedSessions()->sessions()->count()}})',
                    'Missed ({{$viewData->sessionsBag()->missedSessionsCount()}})',
                    'Remaining ({{$viewData->sessionsBag()->remainedSessionsCount()}})',],
                datasets: [{
                    data: [ {{$viewData->sessionsBag()->completedPercentage()}},
                        {{$viewData->sessionsBag()->missedPercentage()}},
                        {{$viewData->sessionsBag()->remainedPercentage()}}], // Valores para cada sección
                    backgroundColor: ['rgb(108, 229, 232)', 'rgb(65, 184, 213)', 'rgb(45, 139, 186)'],
                    hoverOffset: 6 // Ajusta el espacio al hacer hover sobre las secciones
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true,
                    }
                }
            }
        });
    });
</script>
