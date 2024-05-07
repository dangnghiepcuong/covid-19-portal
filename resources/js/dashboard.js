$(document).ready(function () {
    window.getTotalDoses()
    window.getTotalPeopleWithOnlyFirstDose()
    window.getTotalPeopleWithOverOneDose()
    window.getTotalPeopleWithNoDose()
})

window.getTotalDoses = function () {
    $.ajax({
        url: 'api/v1/dashboard/totalDoses',
        method: 'GET',
        success: function (result) {
            $('#card-primary').text(result)
        }
    })
}

window.getTotalPeopleWithOnlyFirstDose = function () {
    $.ajax({
        url: 'api/v1/dashboard/totalPeopleWithOnlyFirstDose',
        method: 'GET',
        success: function (result) {
            $('#card-warning').text(result)
        }
    })
}

window.getTotalPeopleWithOverOneDose = function () {
    $.ajax({
        url: 'api/v1/dashboard/totalPeopleWithOverOneDose',
        method: 'GET',
        success: function (result) {
            $('#card-success').text(result)
        }
    })
}

window.getTotalPeopleWithNoDose = function () {
    $.ajax({
        url: 'api/v1/dashboard/totalPeopleWithNoDose',
        method: 'GET',
        success: function (result) {
            $('#card-danger').text(result)
        }
    })
}
