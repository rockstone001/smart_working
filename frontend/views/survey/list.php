<!--活动列表页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <?php include(VIEWPATH . 'include/header.php')?>
                    <div class="page__bd">
                        <div class="weui-cells list">

                        </div>
                    </div>
                </div>
                <?php include(VIEWPATH . 'include/footer.php')?>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            get_list();
        });
</script>
</script>




<script>
var survey_id = 0;

window.onload = function(){
};
var list_url = '<?php echo config_item('index_url')?>/survey/get_list';
var detail_url = '<?php echo config_item('index_url')?>/survey/index';

function get_list()
{
    var city = $('#citySelectBtn').html();
    var type = $('#typeSelectBtn').html();
    var startTime = $('#timeTypeSelectBtn').html();
    $.getJSON(list_url, {
        city: city,
        type: type,
        start_time: startTime
    }, function(data) {
//            console.log(data);
        if (data.code == 0) {
            var html = '';
            for (var i = 0; i < data.msg.length; i ++) {
                html += '<a class="weui-cell weui-cell_access lesson_item" href="javascript:;" data-link="detail" data-id="' + data.msg[i].id + '" data-title="' + data.msg[i].title + '">';
                html += '<div class="weui-cell__hd"></div>';
                html += '<div class="weui-cell__bd right5"><p>' + data.msg[i].title + '</p></div>';
                html += '<div class="weui-cell__ft"></div></a>';
            }
        }
        $('.list').html(html);
        $('.lesson_item').on('click', function(){
//                window.pageManager.go($(this).data('link'));
//                var title = $(this).data('title');
            var id = $(this).data('id');
//                setTimeout(function(){
//                    $('.detail .title').html(title);
//                    $('#joinBtn').on('click', function(){
//                        window.pageManager.go($(this).data('link'));
//                        setTimeout(function(){
//                            get_join_page(title, id);
//                        }, 100);
//
//                    });
//                }, 100);
//
//                get_detail(id);
            location.href = detail_url + '?id=' + id;
        });
    });
}

//这里有一个很大的问题 模板和数据不能互相通信 后期将要使用vue.js模板绑定数据  或者使用其他的模板引擎
</script>