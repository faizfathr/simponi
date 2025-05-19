const halfDonutChart = (idElemen, data) => {
    const elementSelector = document.getElementById(idElemen);
    if(elementSelector) {
        const chartOptions = {
            series: [data],
            colors: ["#465FFF"],
            chart: {
                fontFamily: "Outfit, sans-serif",
                type: "radialBar",
                height: 430,
                sparkline: {
                    enabled: true,
                },
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    hollow: {
                        size: "80%",
                    },
                    track: {
                        background: "#E4E7EC",
                        strokeWidth: "100%",
                        margin: 5, // margin is in pixels
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            fontSize: "36px",
                            fontWeight: "600",
                            offsetY: -60,
                            color: "#1D2939",
                            formatter: function (val) {
                                return val + "%";
                            },
                        },
                    },
                },
            },
            fill: {
                type: "solid",
                colors: ["#465FFF"],
            },
            stroke: {
                lineCap: "round",
            },
            labels: ["Progress"],
        };
        const chart = new ApexCharts(elementSelector, chartOptions);
        chart.render();
    }
};
const idXData = document.querySelector('#id-monitoring');
const xData = Alpine.$data(idXData);

const subsektorActived = xData.idMonitoring;
fetch('/dashboard/dataPersentase', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
        tahun: 2025,
        subsektor: subsektorActived,
    })
})
    .then(responses => responses.json())
    .then(responses => {
        responses.map((response) => {
            halfDonutChart(response.id,  parseFloat(response.realisasi/response.target*100).toFixed(2))
        })
    })
