const barChart = (idElemen = '#', data) => {

  const chartSelector = document.getElementById(idElemen);

  if (chartSelector) {

    const chartOptions = {
      series: data.series, // Diterima dari backend
      colors: ["#465fff", "#F4631E"],
      chart: {
        fontFamily: "Outfit, sans-serif",
        type: "bar",
        height: 180,
        toolbar: {
          show: false,
        },
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "39%",
          borderRadius: 5,
          borderRadiusApplication: "end",
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 4,
        colors: ["transparent"],
      },
      xaxis: {
        categories: data.categories, // Diterima dari backend
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      legend: {
        show: true,
        position: "top",
        horizontalAlign: "left",
        fontFamily: "Outfit",
        markers: {
          radius: 99,
        },
      },
      yaxis: {
        title: false,
      },
      grid: {
        yaxis: {
          lines: {
            show: true,
          },
        },
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        x: {
          show: false,
        },
        y: {
          formatter: function (val) {
            return val;
          },
        },
      },
    };

    const chart = new ApexCharts(chartSelector, chartOptions);
    chart.render();
  }
}
const idXData2 = document.querySelector('#id-monitoring');
const xData2 = Alpine.$data(idXData2);

const subsektorActived2 = xData2.idMonitoring;
fetch('/dashboard/data', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  body: JSON.stringify({
    tahun: 2025,
    subsektor: subsektorActived2,
  })
})
  .then(responses => responses.json())
  .then(responses => {
    responses.forEach((response) => {
      barChart(response.id_kegiatan, {
        categories: response.categories,
        series: [
          {
            name: 'Target',
            data: response.target
          },
          {
            name: 'Realisasi',
            data: response.realisasi
          },
        ]
      })
    })
  })