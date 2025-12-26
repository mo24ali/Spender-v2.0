const ctx = document.getElementById("chart");
const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

let monthlyIncome = new Array(12).fill(0);
let monthlyExpense = new Array(12).fill(0);

inc.forEach(el => {
    let mIndex = parseInt(el.month) - 1; 
    monthlyIncome[mIndex] += parseFloat(el.price);
});

exp.forEach(el => {
    let mIndex = parseInt(el.month) - 1;
    monthlyExpense[mIndex] += parseFloat(el.price);
});

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: monthNames,
        datasets: [
            {
                label: 'Income',
                data: monthlyIncome,
                backgroundColor: '#008FFB88',
                borderColor: '#008FFB',
                borderWidth: 1
            },
            {
                label: 'Expenses',
                data: monthlyExpense,
                backgroundColor: '#00E39688',
                borderColor: '#00E396',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});