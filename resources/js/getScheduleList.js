$(document).ready(function () {
    $('#table_schedule_list_info').text(
        window.trans(
            'component.paginating_info',
            { 'from': 0, 'to': 0, 'per_page': 0 }
        )
    )

    $('#table_business_list tbody').on('click', 'tr td button', function () {
        let business_id = $(this).val()
        let business_name = $(this).parent().parent().find('td:eq(1)').text()
        let business_addr_province = $(this).parent().parent().find('td:eq(2)').text()
        let business_addr_district = $(this).parent().parent().find('td:eq(3)').text()
        let business_addr_ward = $(this).parent().parent().find('td:eq(4)').text()
        $('#chosen_business').text(
            `${business_name} (${business_addr_province}, ${business_addr_district}, ${business_addr_ward})`
        )
        $('#chosen_business').val(business_id)

        let from_date = $('#from_date').val()
        let to_date = $('#to_date').val()
        let vaccine_id = $('#vaccine_id').val()

        window.callApiGetScheduleList("/api/v1/schedules", business_id, from_date, to_date, vaccine_id)
    })

    $('#btn_apply_schedule_filter').on('click', function () {
        let business_id = $('#chosen_business').val()
        let from_date = $('#from_date').val()
        let to_date = $('#to_date').val()
        let vaccine_id = $('#vaccine_id').val()

        window.callApiGetScheduleList("/api/v1/schedules", business_id, from_date, to_date, vaccine_id)
    })

    $('#table_schedule_list_paginating').on('click', 'li a', function () {
        let url = $(this).attr('value')
        getPaginatingSchedule(url)
    })
})

function getPaginatingSchedule(url)
{
    if (!url) {
        return
    }

    let business_id = $('#chosen_business').val()
    let from_date = $('#from_date').val()
    let to_date = $('#to_date').val()
    let vaccine_id = $('#vaccine_id').val()

    window.callApiGetScheduleList(url, business_id, from_date, to_date, vaccine_id)
}

window.callApiGetScheduleList = function (url, business_id, from_date, to_date, vaccine_id) {
    $.ajax({
        cache: false,
        url: url,
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
            } else {
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
            }

            $('#table_schedule_list_paginating li:eq(0) a').attr('value', result.first_page_url)
            $('#table_schedule_list_paginating li:eq(1) a').attr('value', result.prev_page_url)
            $('#table_schedule_list_paginating li:eq(2) a').attr('value', result.next_page_url)
            $('#table_schedule_list_paginating li:eq(3) a').attr('value', result.last_page_url)
            $('#table_schedule_list_info').text(
                window.trans(
                    'component.paginating_info',
                    {
                        'from': (result.from === null ? 0 : result.from),
                        'to': (result.to === null ? 0 : result.to),
                        'per_page': result.per_page
                    }
                )
            )
        },
    })
}
