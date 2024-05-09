import Chart from 'chart.js/auto';

$(document).ready(function () {
    window.drawBarChart()
})

window.drawBarChart = function () {
    window.getVaccineUsageData()
}

window.getVaccineUsageData = function () {
    $.ajax({
        cache: false,
        url: 'api/v1/dashboard/vaccinationUsageData',
        method: 'GET',
        success: function (result) {
            console.log(result)
            let labels = []
            let vaccineUsageData = []
            for (let element of result) {
                labels.push(element['name'])
                vaccineUsageData.push(element['usage'])
            }
            const data = {
                labels: labels,
                datasets: [{
                    label: window.trans('dashboard.bar_chart_title'),
                    data: vaccineUsageData,
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgb(153, 102, 255)',
                    ],
                    borderWidth: 1
                }]
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: false,
                },
            };
            let ctx = $("#barChart");
            new Chart(ctx, config);
        }
    })
}
