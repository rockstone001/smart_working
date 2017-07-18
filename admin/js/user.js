$(function() {
    $('#submit_btn').on('click', function () {
        var username = $('#username').val();
        var pwd = $('#password').val();
        var repwd = $('#re-password').val();
        var mobile = $('#mobile').val();
        var role_id = $('#role_id').val();
        var company_id = $('#company_id').val();
        var department = $('#department').val();
        var position = $('#position').val();
        var employee_id = $('#employee_id').val();
        var email = $('#email').val();
        var address = $('#address').val();

        if (pwd != repwd) {
            $('#operate_dialog .modal-body').html('两次输入密码不一致!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
            return;
        }
        if ($.trim(username) == '') {
            $('#operate_dialog .modal-body').html('用户名不能为空!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
            return;
        }

        $.post($('#user_form').attr('action'), {
            username: username,
            password: pwd,
            mobile: mobile,
            role_id: role_id,
            company_id: company_id,
            department: department,
            position: position,
            employee_id: employee_id,
            email: email,
            address: address
        }, function(data){
            if (data.code != 0) {
                if (!$('#msg').hasClass('alert-error')) {
                    $('#msg').addClass('alert-error')
                }
                $('#msg h4').html(data.msg);
                $('#msg').show();
            } else {
                location.href = data.msg.link;
            }
        }, 'JSON');
    });

    $('#company_id').on('change', function(){
        var company_id = $(this).val();
        var html= '';
        if (company_id > 0) {
            var cur_company = company_city_store[company_id];
            var cur_cities = cur_company['city'];
            html = '<option value="0">无</option>';
            for (var id in cur_cities) {
                html += '<option value="' + id + '">' + cur_cities[id].name + '</option>';
            }
        } else {
            for (var id in cities) {
                html += '<option value="' + id + '">' + cities[id] + '</option>';
            }
        }
        $('#city_id').html(html);
    });

    $('#city_id').on('change', function() {
        var company_id = $('#company_id').val();
        var city_id = $(this).val();
        var html= '';
        if (company_id > 0) {
            if (city_id > 0) {
                var cur_company = company_city_store[company_id];
                var cur_stores = cur_company['city'][city_id]['store'];
                html = '<option value="0">无</option>';
                for (var id in cur_stores) {
                    html += '<option value="' + id + '">' + cur_stores[id] + '</option>';
                }
            } else {
                for (var id in stores) {
                    html += '<option value="' + id + '">' + stores[id] + '</option>';
                }
            }
            $('#store_id').html(html);
        }
    });
});



