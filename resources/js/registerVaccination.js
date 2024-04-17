$(document).ready(function () {
    $('#alert').addClass('hidden');

    $('#table_schedule_list tbody').on('click', 'tr td button', function () {
        let message = window.trans(
            'message.confirm',
            {'action': window.trans('btn.register')}
        )

        if (!confirm(message)) {
            return
        }

        let schedule_id = $(this).val()
        let shift = $(this).parent().find('select option:selected').val()
        window.callApiRegisterVaccination("/vaccination", schedule_id, shift)
    })
})

window.callApiRegisterVaccination = function (url, schedule_id, shift) {
    $.ajax({
        cache: false,
        url: url,
        method: 'POST',
        data: {
            _token: window.csrf_token,
            schedule_id: schedule_id,
            shift: shift,
        },
        success: function (result) {
            console.log(result)
            $('#alert div ul').html(`<li>${result['message']}</li>`)
            switch (result['status']) {
            case 'success':
                $('#alert div').addClass('alert-success')
                $('#alert').removeClass('hidden')
                break

            case 'warning':
                $('#alert div').addClass('alert-warning')
                $('#alert').removeClass('hidden')
                break

            case 'failed':
                $('#alert div').addClass('alert-danger')
                $('#alert').removeClass('hidden')
                break
            }
        },
        error: function (error) {
            console.log(error)
        }
    })
}
