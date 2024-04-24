$(document).ready(function () {
    let addr_province = $('#addr_province').attr('value')
    let addr_district = $('#addr_district').attr('value')
    let addr_ward = $('#addr_ward').attr('value')

    getProvinceList(addr_province)
    getDistrictList(addr_province, addr_district)
    getWardList(addr_province, addr_district, addr_ward)

    $('#addr_province').on('change', function () {
        $('option:selected', this);
        let addr_province = this.value
        getDistrictList(addr_province)
        $('#addr_ward').html('')
    })

    $('#addr_district').on('change', function () {
        let addr_province = $('#addr_province option:selected').val();
        $('option:selected', this);
        let addr_district = this.value
        getWardList(addr_province, addr_district)
    })
})

var getProvinceList = function (addr_province) {
    $.ajax({
        cache: false,
        url: "/local/province_list",
        type: 'GET',
        success: function (result) {
            if (result == null) {
                return;
            }
            let optionStr = '<option value=""></option>'
            $.each(result, function (index, element) {
                optionStr += `<option value="${index}">${element}</option>`
            })
            $('#addr_province').html(optionStr)
            if (addr_province != null) {
                $('#addr_province').val(addr_province)
            }
        },
    })
}

var getDistrictList = function (addr_province, addr_district) {
    $.ajax({
        url: "/local/district_list",
        type: 'GET',
        data: { addr_province: addr_province },
        success: function (result) {
            if (result == null) {
                return;
            }
            let optionStr = '<option value=""></option>'
            $.each(result, function (index, element) {
                optionStr += `<option value="${index}">${element}</option>`
            })
            $('#addr_district').html(optionStr)
            if (addr_district != null) {
                $('#addr_district').val(addr_district)
            }
        },
    })
}

var getWardList = function (addr_province, addr_district, addr_ward) {
    $.ajax({
        url: "/local/ward_list",
        type: 'GET',
        data: { addr_province: addr_province, addr_district: addr_district },
        success: function (result) {
            if (result == null) {
                return;
            }
            let optionStr = '<option value=""></option>'
            $.each(result, function (index, element) {
                optionStr += `<option value="${index}">${element}</option>`
            })
            $('#addr_ward').html(optionStr)

            if (addr_ward != null) {
                $('#addr_ward').val(addr_ward)
            }
        },
    })
}
