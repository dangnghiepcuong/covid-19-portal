$(document).ready(function () {
    $('#table_business_list tbody').on('click', 'tr td button', function () {
        let business_id = $(this).val()
        let from_date = $('#from_date').val()
        let to_date = $('#to_date').val()
        let vaccine_id = $('#vaccine_id').val()

        $.ajax({
            cache: false,
            url: "api/v1/schedules",
            method: 'GET',
            data: {
                business_id: business_id,
                from_date: from_date,
                to_date: to_date,
                vaccine_id: vaccine_id,
            },
            success: function (result) {
                $('#table_schedule_list tbody').html('')
                let i = 0;
                if (result.data == '') {
                    $('#table_schedule_list tbody').append(
                        `<tr>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                            <td>${window.trans('message.no_data')}</td>
                        </tr>`
                    )
                    return
                }

                for (let element of result.data) {
                    $('#table_schedule_list tbody').append(
                        `<tr>
                            <td class="text-center">${++i}</td>
                            <td class="text-center">${element['on_date']}</td>
                            <td class="text-center">${element['vaccine_lot']['vaccine']['name']}</td>
                            <td class="text-center">${element['vaccine_lot']['lot']}</td>
                            <td class="text-center">${element['day_shift']}</td>
                            <td class="text-center">${element['noon_shift']}</td>
                            <td class="text-center">${element['night_shift']}</td>
                            <td class="text-center"></td>
                        </tr>`
                    )
                }
            },
        })
    })
})
