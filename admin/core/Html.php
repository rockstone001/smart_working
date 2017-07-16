<?php
/**
 * 扩展CI_Controller类, 目的是在处理请求逻辑之前统一为每个请求做处理
 * @author zhuang
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Html {

	public static function tag($tagName, $callback)
    {
        $html = '<div class="tag"><span class="tag_name">' . $tagName . '</span><a class="tag_close" href="javascript:;" onclick="' . $callback . '(this);$(this).parent().remove();">X</a><input type="hidden" name="cities[]" value="' . $tagName . '"></div>';
        echo $html;
    }
}
