<?php
//var_dump(count($questions)); die();
?>
<!--订单列表页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page survey">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                <header class="header">
                    <h1 class="title">问卷调查</h1>
                </header>
                <article class="weui-article">
                    <h1>亲爱的学友:</h1>
                    <p class="article-p"><?php echo $header;?></p>
                    <p>&nbsp;</p>
                    <?php if (!$if_answered) { ?>
                    <p><a href="javascript:;" class="js_item weui-btn weui-btn_primary" data-link="survey">开始问卷</a></p>
                    <?php } else { ?>
                        <p class="red">您已经参与过此问卷, 感谢您的参与!</p>
                        <p><a href="<?php echo config_item('index_url') . '/survey/survey_list'?>" class="weui-btn weui-btn_primary" data-link="survey_list">返回</a></p>

                    <?php }?>
                </article>
                    </div>
                <?php include(VIEWPATH . 'include/footer.php')?>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('.js_item').on('click', function(){
                var link = $(this).data('link');
                window.pageManager.go(link);
            });
        });
    </script>
</script>

<script type="text/html" id="tpl_survey">
    <div class="page survey">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-navbar" style="position:fixed">
                <div class="weui-navbar__item my_navbar">
                    <a class="js_item mui-icon mui-icon-left-nav" id="detail_title" data-link="home"></a>
                    <h4 class="title">问卷调查</h4>
                </div>
            </div>
            <div class="page-question">
                <?php for ($i=0; $i<count($questions); $i++) { ?>
                <div class="qpage">
                    <p>&nbsp;</p>
                <?php if (in_array($questions[$i]['type'], ['checkbox', 'radio'])) { ?>
                    <div class="weui-cells__title"><?php echo ($i + 1) . '、' . $questions[$i]['question']?></div>
                    <div class="weui-cells weui-cells_radio answer" id="answer_<?php echo $i;?>" data-type="<?php echo $questions[$i]['type']?>">
                        <?php foreach ($questions[$i]['answer'] as $k=>$v) {?>
                        <label class="weui-cell weui-check__label" for="q_<?php echo $i?>_a_<?php echo $k?>">
                            <div class="weui-cell__bd">
                                <p><?php echo $k . '、' . $v?></p>
                            </div>
                            <div class="weui-cell__ft">
                                <input type="<?php echo $questions[$i]['type']?>" name="q_<?php echo ($i + 1)?>" class="weui-check" id="q_<?php echo $i?>_a_<?php echo $k?>" checked="checked" value="<?php echo $k ?>">
                                <span class="weui-icon-checked"></span>
                            </div>
                        </label>
                        <?php }?>
                    </div>
                    <?php } else if ($questions[$i]['type'] == 'text'){?>
                    <div class="weui-cells__title"><?php echo ($i + 1) . '、' . $questions[$i]['question']?></div>
                    <div class="weui-cell">
                        <div class="weui-cell__bd" id="answer_<?php echo $i;?>" data-type="<?php echo $questions[$i]['type']?>">
                            <textarea class="weui-textarea" placeholder="请输入建议" rows="3" name="q_<?php echo ($i + 1)?>"></textarea>
                        </div>
                    </div>
                    <?php } if ($i == (count($questions) - 1)) {?>
                    <p>&nbsp;</p>
                    <article class="weui-article">
                        <p><a href="javascript:;" class="weui-btn weui-btn_primary" id="submitBtn">提交问卷</a></p>
                    </article>
                    <?php }?>
                </div>
                <?php }?>
            </div>
            <button class="continue mui-icon mui-icon-arrowthindown"></button>
        </div>
    </div>
    <!-- loading toast -->
    <div id="loadingToast" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-loading weui-icon_toast"></i>
            <p class="weui-toast__content">正在保存中</p>
        </div>
    </div>

    <div class="weui-dialog_alert" id="tips_dialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title title"></strong></div>
            <div class="weui-dialog__bd content"></div>
            <div class="weui-dialog__ft">
                <a href="javascript:;" class="primary weui-dialog__btn">确定</a>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('.js_item').on('click', function(){
                var link = $(this).data('link');
                window.pageManager.go(link);
            });
            $('.weui-dialog__btn').on('click', function () {
                $('#tips_dialog').hide();
            });
            $('.weui-check').removeAttr('checked');
            var pageHeight = parseInt($('.page-question').height());

            $('.continue').on('click', function() {
                var index = getIndex();
                var type = $('#answer_' + index).data('type');

                if (!checkInputEmpty(index, type)) {
                    $('#tips_dialog').show();
                    $('#tips_dialog .title').html('操作提示');
                    $('#tips_dialog .content').html(type == 'text' ? '请填写答案' : '请选择答案');
                    return;
                }

                if (index + 2 == $('.qpage').length) {
                    $('.continue').hide();
                }

                if (index < $('.qpage').length) {
                    $('.qpage:first-child').animate({
                        'marginTop' : -(index + 1) * pageHeight
                    }, 500);

                }
            });
            $('#submitBtn').on('click', function() {
                var index = getIndex();
                var type = $('#answer_' + index).data('type');
                if (!checkInputEmpty(index, type)) {
                    $('#tips_dialog').show();
                    $('#tips_dialog .content').html(type == 'text' ? '请填写答案' : '请选择答案');
                    return;
                }
                $('#loadingToast').show();
                var params = getParams();
                $.ajax({
                    url: '<?php echo config_item('index_url')?>/survey/save?id=<?php echo $id?>',
                    type: 'POST',
                    data: params,
                    dataType: 'json',
                    success: function(data) {
                        $('#loadingToast').hide();
                        $('#tips_dialog .content').html(data.msg);
                        if (data.code == '0' ) {
                            $('#tips_dialog .title').html('操作提示');
                            $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                                $('#tips_dialog').hide();
                                location.href = '<?php echo config_item('index_url')?>/survey/survey_list';
                            });
                        } else {
                            $('#tips_dialog .title').html('错误提示');
                            $('#tips_dialog').show();
                        }
                    }
                });
            });
            function getIndex()
            {
                var offsetTop = parseInt($('.qpage:first-child').css('marginTop') || 0);
                var index = Math.abs(offsetTop) / pageHeight;
                return index;
            }
            function checkInputEmpty(index, type) {
                var can_continue = false;
                if (type != 'text') {
                    if ($('input[name="q_' + (index + 1) + '"]:checked').length > 0) {
                        can_continue = true;
                    }
                } else {
                    if (!/^\s*$/.test($('textarea[name="q_' + (index + 1) + '"]').val())) {
                        can_continue = true;
                    }
                }
                return can_continue;
            }
            function getParams()
            {
                var params = '';
                for (var index = 0; index < $('.qpage').length; index ++) {
                    var type = $('#answer_' + index).data('type');
                    switch (type) {
                        case 'text':
                            params = joinUrlParams(params, 'a' + index, $('textarea[name="q_' + (index + 1) + '"]').val());
                            break;
                        case 'radio':
                            params = joinUrlParams(params, 'a' + index, $('input[name="q_' + (index + 1) + '"]:checked').val());
                            break;
                        case 'checkbox':
                            var inputs = $('input[name="q_' + (index + 1) + '"]:checked');
                            var value = [];
                            for (var i = 0; i < inputs.length ; i ++) {
                                value.push($(inputs[i]).val());
                            }
                            params = joinUrlParams(params, 'a' + index, value.join(','));
                            break;
                    }
                }
                return params;
            }
            function joinUrlParams(params, key, value) {
                if (params == '') {
                    params = key + '=' + value;
                } else {
                    params += '&' + key + '=' + value;
                }
                return params;
            }
        });

</script>
</script>