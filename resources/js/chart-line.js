import Chart from 'chart.js/auto';

$(document).ready(function () {
    window.drawLineChart()
})

window.drawLineChart = function () {
    window.getMonthlyVaccinationData()
}

window.getMonthlyVaccinationData = function () {
    let today = new Date()
    let d
    let monthYear
    let labels = []

    for (let i = 5; i >= 0; i -= 1) {
        d = new Date(today.getFullYear(), today.getMonth() - i, 1);
        monthYear = { 'month': d.getMonth() + 1, 'year': d.getFullYear() }
        labels.push(monthYear)
    }

    $.ajax({
        cache: false,
        url: 'api/v1/dashboard/monthlyVaccinationData',
        method: 'GET',
        success: function (result) {
            let vaccinationData = []
            for (let label of labels) {
                vaccinationData.push(0)
                for (let element of result) {
                    if (parseInt(element['year']) === parseInt(label['year']) && parseInt(element['month']) === parseInt(label['month'])) {
                        vaccinationData[vaccinationData.length - 1] = element.data
                    }
                }
            }
            let plainLabels = []
            for (let label of labels) {
                plainLabels.push(`${label['month']}/${label['year']}`)
            }
            const data = {
                labels: plainLabels,
                datasets: [{
                    label: window.trans('dashboard.line_chart_title'),
                    data: vaccinationData,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                    ],
                    borderWidth: 2
                }]
            };
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: false,
                },
            };
            let ctx = $("#lineChart");
            new Chart(ctx, config);
        }
    })
}
