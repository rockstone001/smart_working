$(function() {
    $('#submit_btn').on('click', function () {
        var name = $('#name').val();
        var city_id = $('#city_id').val();
        var address = $('#address').val();
        var telephone = $('#telephone').val();

        if ($.trim(name) == '') {
            $('#operate_dialog .modal-body').html('城市名不能为空!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
            return;
        }

        $.post($('#city_form').attr('action'), {
            name: name,
            city_id: city_id,
            address: address,
            telephone: telephone
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



