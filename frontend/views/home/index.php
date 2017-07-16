<!--活动列表页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <?php include(VIEWPATH . 'include/header.php')?>
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item select" id="citySelectBtn">全部城市</div>
                        <div class="weui-navbar__item select" id="typeSelectBtn">全部类型</div>
                        <div class="weui-navbar__item select" id="timeTypeSelectBtn">半年内</div>
                        <div></div>
                    </div>
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
            $('#citySelectBtn').on('click', function () {
                weui.picker(cities, {
                    onChange: function (result) {
                    },
                    onConfirm: function (result) {
                        $('#citySelectBtn').html(result[0]||"全部城市");
                        get_list();
                    },
                    id: "citySelector",
                    triggerElem: this
                });
            });
            $('#typeSelectBtn').on('click', function () {
                weui.picker(lesson_type, {
                    onChange: function (result) {
                    },
                    onConfirm: function (result) {
                        $('#typeSelectBtn').html(result[0]||"全部类型");
                        get_list();
                    },
                    id: "typeSelector",
                    triggerElem: this
                });
            });
            $('#timeTypeSelectBtn').on('click', function () {
                weui.picker(time_type, {
                    onChange: function (result) {
                    },
                    onConfirm: function (result) {
                        $('#timeTypeSelectBtn').html(result[0]);
                        get_list();
                    },
                    id: "timeTypeSelector",
                    triggerElem: this
                });
            });
            get_list();
        });
    </script>
</script>




<script>
    var detail_id = 0;
    <?php
        $cities = config_item('cities');
        $city_formatted = [[
            'label' => '全部城市',
            'value' => ''
        ]];

        foreach ($cities as $c) {
            $city_formatted[] = [
                'label' => $c['name'],
                'value' => $c['name']
            ];
        }
        echo 'var cities = ' . json_encode($city_formatted) . ';';

        $lesson_type = config_item('lesson_type');
        $lesson_type_formatted = [[
            'label' => '全部类型',
            'value' => ''
        ]];

        foreach ($lesson_type as $c) {
            $lesson_type_formatted[] = [
                'label' => $c,
                'value' => $c
            ];
        }
        echo 'var lesson_type = ' . json_encode($lesson_type_formatted) . ';';

        $time_type = config_item('time_type');
        $time_type_formatted = [];

        foreach ($time_type as $k=>$c) {
            $time_type_formatted[] = [
                'label' => $k,
                'value' => $k
            ];
        }
        echo 'var time_type = ' . json_encode($time_type_formatted) . ';';
    ?>
    window.onload = function(){
    };
    var list_url = '<?php echo config_item('index_url')?>/home/get_list';
    var detail_url = '<?php echo config_item('index_url')?>/home/detail';

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
                    html += '<div class="weui-cell__hd"><img src="' + data.msg[i].image + '" alt="" style="width:60px;margin-right:5px;display:block"></div>';                     html += '<div class="weui-cell__bd right5"><p>' + data.msg[i].title + '</p></div>';
                    html += '<div class="weui-cell__ft">' + data.msg[i].start_time.substr(0, 10) + '</div></a>';
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