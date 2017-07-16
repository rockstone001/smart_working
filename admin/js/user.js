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
});



