$(document).ready(function () {
    $('#table_business_list_info').text(
        window.trans(
            'component.paginating_info',
            {'from': 0, 'to': 0, 'per_page': 0}
        )
    )

    $('#btn_apply_business_filter').on('click', function () {
        $('#table_schedule_list tbody').html('')
        $('#chosen_business').text('')
        let addr_province = $('#addr_province').val()
        let addr_district = $('#addr_district').val()
        let addr_ward = $('#addr_ward').val()

        window.callApiGetBusinessList("/api/v1/businesses", addr_province, addr_district, addr_ward)
    })

    $('#table_business_list_paginating').on('click', 'li a', function () {
        let url = $(this).attr('value')
        getPaginatingBusiness(url)
    })
})

function getPaginatingBusiness(url)
{
    if (!url) {
        return
    }

    $('#table_schedule_list tbody').html('')
    let addr_province = $('#paginating_current_addr_province').val()
    let addr_district = $('#paginating_current_addr_district').val()
    let addr_ward = $('#paginating_current_addr_ward').val()

    window.callApiGetBusinessList(url, addr_province, addr_district, addr_ward)
}

window.callApiGetBusinessList = function (url, addr_province, addr_district, addr_ward) {
    $.ajax({
        cache: false,
        url: url,
        method: 'GET',
        data: {
            addr_province: addr_province,
            addr_district: addr_district,
            addr_ward: addr_ward,
        },
        success: function (result) {
            $('#table_business_list tbody').html('')
            let i = 0;
            for (let element of result.data) {
                $('#table_business_list tbody').append(
                    `<tr>
                        <td class="text-left text-truncate my-auto">
                            ${++i}
                        </td>
                        <td class="text-left text-truncate my-auto">
                            ${element['name']}
                        </td>
                        <td class="text-left text-truncate my-auto">
                            ${element['addr_province_name']}
                        </td>
                        <td class="text-left text-truncate my-auto">
                            ${element['addr_district_name']}
                        </td>
                        <td class="text-left text-truncate my-auto">
                            ${element['addr_ward_name']}
                        </td>
                        <td class="text-left text-truncate my-auto">
                            ${element['schedules'].length}
                        </td>
                        <td class="flex justify-center">
                            <button class="btn btn-info text-truncate my-auto" value="${element['id']}">
                                View schedules »
                            </button>
                        </td>
                    </tr>`
                )
            }

            $('#paginating_current_addr_province').val(addr_province)
            $('#paginating_current_addr_district').val(addr_district)
            $('#paginating_current_addr_ward').val(addr_ward)
            $('#table_business_list_paginating li:eq(0) a').attr('value', result.first_page_url)
            $('#table_business_list_paginating li:eq(1) a').attr('value', result.prev_page_url)
            $('#table_business_list_paginating li:eq(2) a').attr('value', result.next_page_url)
            $('#table_business_list_paginating li:eq(3) a').attr('value', result.last_page_url)
            $('#table_business_list_info').text(
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
