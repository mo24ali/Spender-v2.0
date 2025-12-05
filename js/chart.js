const ctx = document.getElementById("chart");

new Chart(ctx, {
    type: "bar",   
    data: {
        labels: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
        datasets: [
            {
                label: "Income",
                type: "bar",
                data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6],
                borderColor: "#008FFB",
                backgroundColor: "#008FFB88",
                yAxisID: "yIncome",
            },
            {
                label: "Cashflow",
                type: "bar",
                data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5],
                borderColor: "#00E396",
                backgroundColor: "#00E39688",
                yAxisID: "yCash",
            },
            {
                label: "Revenue",
                type: "line",
                data: [20, 29, 37, 36, 44, 45, 50, 58],
                borderColor: "#FEB019",
                backgroundColor: "#FEB019",
                fill: false,
                borderWidth: 3,
                yAxisID: "yRevenue",
            }
        ]
    },

    options: {
        responsive: true,
        interaction: {
            mode: "index",
            intersect: false
        },

        plugins: {
            title: {
                display: true,
                text: "XYZ - Stock Analysis (2009 - 2016)",
                align: "start",
                padding: 20,
                font: { size: 18 }
            },
            legend: {
                position: "top",
                align: "start"
            }
        },

        scales: {
            yIncome: {
                type: "linear",
                position: "left",
                title: {
                    display: true,
                    text: "Income (thousand crores)",
                    color: "#008FFB"
                },
                ticks: { color: "#008FFB" }
            },

            yCash: {
                type: "linear",
                position: "right",
                title: {
                    display: true,
                    text: "Operating Cashflow (thousand crores)",
                    color: "#00E396"
                },
                ticks: { color: "#00E396" },
                grid: { drawOnChartArea: false }
            },

            yRevenue: {
                type: "linear",
                position: "right",
                title: {
                    display: true,
                    text: "Revenue (thousand crores)",
                    color: "#FEB019"
                },
                ticks: { color: "#FEB019" },
                grid: { drawOnChartArea: false }
            }
        }
    }
});