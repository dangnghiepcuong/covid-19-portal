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
        url: "http://127.0.0.1:8000/local/province_list",
        type: 'GET',
        success: function (result) {
            if (result == null) {
                return;
            }
            let optionStr = '<option value=""></option>'
            let i = 0;
            result.forEach(element => {
                optionStr += '<option value="' + indexToCode(i, 2) + '">' + element + '</option>'
                i++
            });
            $('#addr_province').html(optionStr)
            if (addr_province != null) {
                $('#addr_province').val(addr_province)
            }
        },
        error: function (error) {
            $('body').html(error.responseText)
        }
    })
}

var getDistrictList = function (addr_province, addr_district) {
    $.ajax({
        url: "http://127.0.0.1:8000/local/district_list",
        type: 'GET',
        data: { addr_province: addr_province },
        success: function (result) {
            if (result == null) {
                return;
            }
            let optionStr = '<option value=""></option>'
            let i = 0
            result.forEach(element => {
                optionStr += '<option value="' + addr_province + indexToCode(i, 2) + '">' + element + '</option>'
                i++
            });
            $('#addr_district').html(optionStr)
            if (addr_district != null) {
                $('#addr_district').val(addr_district)
            }
        },
        error: function (error) {
            $('body').html(error.responseText)
        }
    })
}

var getWardList = function (addr_province, addr_district, addr_ward) {
    $.ajax({
        url: "http://127.0.0.1:8000/local/ward_list",
        type: 'GET',
        data: { addr_province: addr_province, addr_district: addr_district },
        success: function (result) {
            if (result == null) {
                return;
            }
            let optionStr = '<option value=""></option>'
            let i = 0
            result.forEach(element => {
                optionStr += '<option value="' + addr_district + indexToCode(i, 2) + '">' + element + '</option>'
                i++
            });
            $('#addr_ward').html(optionStr)

            if (addr_ward != null) {
                $('#addr_ward').val(addr_ward)
            }
        },
        error: function (error) {
            $('body').html(error.responseText)
        }
    })
}

var indexToCode = function (i, code_len) {
    let index = i.toString()
    while (index.length < code_len) {
        index = '0' + index
    }
    return index
}
