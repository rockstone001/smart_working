$(function() {
    //呼出上传图片的 选择图片控件
    $('#pic_upload_btn').click(function() {
        $('#pic_upload').trigger('click');
    });
    //选择图片且图片有改变的时候触发上传事件
    $('#pic_upload').bind('change', function() {
        var _form = $('#upload_form');
        //重建元素
        for (var i = 0; i < _form.children().length; i ++) {
            $(_form.children()[i]).remove();
        }
        var file_elem = $('#pic_upload');
        var new_file_elem = file_elem.clone(true, true);

        file_elem.parent().append(new_file_elem);

        file_elem.appendTo(_form[0]);
        //上传文件
        _form[0].submit();
    });

    $('#copy_btn').click(function(){
        $('#main_pic').focus().select();
    });


    var editor = new wangEditor('desc');
    editor.create();
    editor.$editorContainer.css('z-index', 2001);

});

function setImagePath(data)
{
    var _li = '<li class="fileContainer"><a class="close" href="###" onclick="$(this).parent().remove();$(\'#pic_url\').hide();$(\'#main_pic\').val(\'\');">X</a><span>' + data.name + '</span><p><a href="' + data.link + '" target="_blank"><img src="' + data.preview + '" /></a></p></li>';
    $('.image-list').html(_li);
    $('#main_pic').val(data.link);
    $('#pic_url').show();
}



