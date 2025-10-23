const donutChart = (idElemen, data) => {
    const elementSelector = document.querySelector(idElemen);
    if (elementSelector) {
        const options = {
        chart: {
            type: 'donut',
            height: 300
        },
        series: [parseInt(data.belum_mulai), parseInt(data.on_progres), parseInt(data.selesai)],
        labels: ['Belum Mulai', 'On Progress', 'Selesai'],
        colors: ['#E5E7EB', '#F59E0B', '#10B981'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true
        }
    };

    const chart = new ApexCharts(elementSelector, options);
    chart.render();
    }
};
