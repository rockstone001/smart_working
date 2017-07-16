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


    var editor = new wangEditor('col_1');
    // 上传图片
    editor.config.uploadImgUrl = '/php/longsha/admin/index.php/common/upload_for_editor';
    editor.config.uploadImgFileName = 'pic_upload';
    editor.create();
    editor.$editorContainer.css('z-index', 2001);

    //var editor2 = new wangEditor('col_2');
    //editor2.config.uploadImgUrl = '/php/longsha/admin/index.php/common/upload_for_editor';
    //editor2.config.uploadImgFileName = 'pic_upload';
    //editor2.config.menus = $.map(wangEditor.config.menus, function(item, key) {
    //    if (item === 'location') {
    //        return null;
    //    }
    //    return item;
    //});
    //editor2.create();
    //editor2.$editorContainer.css('z-index', 2002);
    $('#start_time_wrapper .date').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        language:'zh-CN',
        autoclose:true,
        todayBtn:false,
        showMeridian:false,
        todayBtn:true,
        todayHighlight:true,
    });

    $('#end_time_wrapper .date').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        language:'zh-CN',
        autoclose:true,
        todayBtn:false,
        showMeridian:false,
        todayBtn:true,
        todayHighlight:true,
    });

});

function setImagePath(data)
{
    var _li = '<li class="fileContainer"><a class="close" href="###" onclick="$(this).parent().remove();$(\'#pic_url\').hide();$(\'#main_pic\').val(\'\');">X</a><span>' + data.name + '</span><p><a href="' + data.link + '" target="_blank"><img src="' + data.preview + '" /></a></p></li>';
    $('.image-list').html(_li);
    $('#image').val(data.link);
    $('#pic_url').show();
}

function city_selected(abbr, name)
{
    var checked = $('#city' + abbr)[0].checked;
    var id = 'addr_' + abbr;
    if (checked) {
        add_address(abbr, name);
        add_start_time(abbr, name);
        add_end_time(abbr, name)
    } else {
        $('#' + id).remove();
        $('#start_time_wrapper_' + abbr).remove();
        $('#end_time_wrapper_' + abbr).remove();
    }
}

function  add_address(abbr, name)
{
    var html = '<div style="margin-top: 5px; display:block;" class="input-prepend address"><span class="add-on">' + name + '</span><input class="input-xxlarge" type="text" placeholder="地址" value="" name="addresses[]"></div>';
    $('#address_wrapper').append(html);
}

function add_start_time(abbr, name)
{
    var id = (new Date()).getTime();
    var html = '<div class="date form_datetime start_time" data-date="" data-date-format="yyyy-mm-dd hh:ii" data-link-field="start_time_' + id + '" >';
    html += '<div class="input-prepend" style="margin-top: 5px">';
    html += '<span class="add-on">' + name + '</span>';
    html += '<input size="16" type="text" value="" readonly>';
    html += '<span class="add-on"><i class="icon-remove"></i></span>';
    html += '<span class="add-on"><i class="icon-th"></i></span>';
    html += '</div>';
    html += '<input type="hidden" id="start_time_' + id + '" name="start_times[]" value="" />'
    html += '</div>';
    $('#start_time_wrapper').append(html);
    $('#start_time_wrapper .date').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        language:'zh-CN',
        autoclose:true,
        todayBtn:false,
        showMeridian:false,
        todayBtn:true,
        todayHighlight:true,
    });
}

function add_end_time(abbr, name)
{
    var id = (new Date()).getTime();
    var html = '<div class="date form_datetime end_time" data-date="" data-date-format="yyyy-mm-dd hh:ii" data-link-field="end_time_' + id + '">';
    html += '<div class="input-prepend" style="margin-top: 5px">';
    html += '<span class="add-on">' + name + '</span>';
    html += '<input size="16" type="text" value="" readonly>';
    html += '<span class="add-on"><i class="icon-remove"></i></span>';
    html += '<span class="add-on"><i class="icon-th"></i></span>';
    html += '</div>';
    html += '<input type="hidden" id="end_time_' + id + '" name="end_times[]" value="" />'
    html += '</div>';
    $('#end_time_wrapper').append(html);
    $('#end_time_wrapper .date').datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        language:'zh-CN',
        autoclose:true,
        todayBtn:false,
        showMeridian:false,
        todayBtn:true,
        todayHighlight:true,
    });
}

function add_tag(tagName, callback) {
    var html = '<div class="tag"><span class="tag_name">' + tagName + '</span><a class="tag_close" href="javascript:;" onclick="' + callback + '(this);$(this).parent().remove();">X</a><input type="hidden" name="cities[]" value="' + tagName + '"></div>';
    return html;
}

function add_city()
{
    var abbr = $('#city_selected').val();
    var name = $('#city_selected').find("option:selected").text();
    $('#cities').append(add_tag(name, 'remove_city'));

    add_address(abbr, name);
    add_start_time(abbr, name);
    add_end_time(abbr, name);
}

function remove_city(elem)
{
    var index = 0;
    var nodes = $('#cities .tag');
    var currentNode = $(elem).parent()[0];
    for (var i = 0; i < nodes.length; i ++) {
        if (nodes[i] == currentNode) {
            index = i;
            break;
        }
    }
    //remove  address & start_time & end_time
    $('.address').eq(index).remove();
    $('.start_time').eq(index).remove();
    $('.end_time').eq(index).remove();
}




