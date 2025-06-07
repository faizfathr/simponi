let apexChartsInstance = {}; 

const mainChart = (idElemen = '#', data = []) => {
    const chartSelector = document.getElementById(idElemen.replace('#', ''));

    if (!chartSelector) return;

    const chartOptions = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            foreColor: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#374151',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 300
                }
            }
        },
        series: [{
            name: 'Progres',
            data: data
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        },
        yaxis: {
            title: {
                text: 'Progres'
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#3B82F6'],
        markers: {
            size: 4
        },
        tooltip: {
            y: {
                formatter: val => `${val} sampel`
            }
        },
        legend: {
            position: 'top'
        }
    };

    if (apexChartsInstance[idElemen]) {
        apexChartsInstance[idElemen].updateSeries([{
            name: 'Progres',
            data: data
        }]);
    } else {
        apexChartsInstance[idElemen] = new ApexCharts(chartSelector, chartOptions);
        apexChartsInstance[idElemen].render();
    }
};
