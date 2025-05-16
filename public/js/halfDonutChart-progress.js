const halfDonutChart = (idElemen, tahun, survei) => {
    const elementSelector = document.querySelector(idElemen);

    if (elementSelector) {
        fetch('/dashboard/dataPersentase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // pastikan token ada di HTML
            },
            body: JSON.stringify({
                survei: survei,
                tahun: tahun,
            })
        })
            .then((response) => response.json())
            .then((data) => {
                const chartOptions = {
                    series: [data.persentase],
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
                const chart = new ApexCharts(elementSelector,chartOptions);
                chart.render();
            })
    }
};

halfDonutChart('#chartProgress', 2025, 'Laporan Ternak Unggas (LTU)')