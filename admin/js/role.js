$(function() {
    $('#submit_btn').on('click', function () {
        var name = $('#name').val();
        var desc = $('#desc').val();
        if ($.trim(name) == '' || $.trim(desc) == '') {
            $('#operate_dialog .modal-body').html('角色名和描述不能为空!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
            return;
        }

        $.post($('#role_form').attr('action'), {
            name: name,
            desc: desc
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



