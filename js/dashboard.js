// import ApexCharts from 'apexcharts'
let options = {
  chart: {
    type: 'line'
  },
  series: [{
    name: 'sales',
    data: [30,40,35,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}
let chartDiv = document.getElementById("chart1");
let chartDiv2 = document.getElementById("chart2");
let chartDiv3 = document.getElementById("chart3");
let chart = new ApexCharts(chartDiv, options);
let chart2 = new ApexCharts(chartDiv2, options);
let chart3 = new ApexCharts(chartDiv3, options);

chart.render();
chart2.render();
chart3.render();