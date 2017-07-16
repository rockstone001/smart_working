<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['access_token'] = array(
    'expire_time' => 24*60*60, //过期时间
    'key' => 'ppHQONBPgW3m7h8EcPrqS14U', //加密的秘钥串
    'sign_msg' => 'oyS1YyatTNlN', // 验签
    'additional_msg' => 'abc' //做冗余数据
);
