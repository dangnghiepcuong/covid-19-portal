$(document).ready(function () {
    $('#btn_apply_filter').on('click', function () {
        let addr_province = $('#addr_province').val()
        let addr_district = $('#addr_district').val()
        let addr_ward = $('#addr_ward').val()

        $.ajax({
            cache: false,
            url: "http://127.0.0.1:8000/api/v1/businesses/",
            method: 'GET',
            data: {
                addr_province: addr_province,
                addr_district: addr_district,
                addr_ward: addr_ward
            },
            success: function (result) {
                $('#table_business_list tbody').html('')
                let i = 0;
                for (let element of result.data) {
                    $('#table_business_list tbody').append(
                        ` < tr >
                        < td class = "text-center" >
                        ${ ++i }
                        < / td >
                        < td class = "text-center" >
                        ${ element['name'] }
                        < / td >
                        < td class = "text-center" >
                        ${ element['addr_province'] }
                        < / td >
                        < td class = "text-center" >
                        ${ element['addr_district'] }
                        < / td >
                        < td class = "text-center" >
                        ${ element['addr_ward'] }
                        < / td >
                        < td class = "text-center" >
                        ${ element['schedules'].length }
                        < / td >
                        < td class = "flex justify-center" >
                        < a class = "btn btn-primary" href = "#" > View schedules < / a >
                        < / td >
                        < / tr > `
                    )
                }
            },
        })
    })
})
