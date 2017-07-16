<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['dianzi'] = [
    [
        'name' => '普通垫子',
        'logo' => '',
        'title' => '普通垫子',
        'desc' => '普通垫子普通垫子普通垫子普通垫子普通垫子'
    ],
    [
        'name' => '智能垫子',
        'logo' => '',
        'title' => '智能垫子',
        'desc' => '智能垫子智能垫子智能垫子智能垫子智能垫子智能垫子智能垫子'
    ],
];

$config['voice'] = [
    [
        'name' => '标准男声',
        'link' => 'http://xxxx',
    ],
    [
        'name' => '标准女声',
        'link' => 'http://xxxx',
    ]
];

$config['mode'] = [
    [
        'name' => '自由静坐',
        'desc' => '说明'
    ],
    [
        'name' => '计时静坐',
        'desc' => '说明',
        'durations' => [
            10, 20, 30, 60, 120
        ], //时间设定

    ],
    [
        'name' => '教学静坐',
        'desc' => '说明',
        'level' => [
            [
                'name' => '教学模式-基础',
                'desc' => '说明1111',
            ],
            [
                'name' => '教学模式-初级',
                'desc' => '说明2222',
            ],
            [
                'name' => '教学模式-中级',
                'desc' => '说明3333',
            ],
            [
                'name' => '教学模式-高级',
                'desc' => '说明4444',
            ],
        ]
    ],
    [
        'name' => '挑战模式静坐',
        'desc' => '说明'
    ]
];

$config['province'] = [
    '北京市' => '京',
    '上海市' => '沪',
    '天津市' => '津',
    '重庆市' => '渝',
    '黑龙江省' => '黑',
    '吉林省' => '吉',
    '辽宁省' => '辽',
    '内蒙古' => '蒙',
    '河北省' => '冀',
    '新疆' => '新',
    '甘肃省' => '甘',
    '青海省' => '青',
    '陕西省' => '陕',
    '宁夏' => '宁',
    '河南省' => '豫',
    '山东省' => '鲁',
    '山西省' => '晋',
    '安徽省' => '皖',
    '湖北省' => '鄂',
    '湖南省' => '湘',
    '江苏省' => '苏',
    '四川省' => '川',
    '贵州省' => '黔',
    '云南省' => '滇',
    '广西省' => '桂',
    '西藏' => '藏',
    '浙江省' => '浙',
    '江西省' => '赣',
    '广东省' => '粤',
    '福建省' => '闽',
    '台湾省' => '台',
    '海南省' => '琼',
    '香港' => '港',
    '澳门' => '澳',
];

$config['level'] = [
    [
        "name" => "LV1",
        'desc' => '初级坐者',
        'next_level1' => 20,
        'next_level2' => 600*60,
        'is_current' => false,
    ],
    [
        "name" => "LV2",
        'desc' => '二级坐者',
        'next_level1' => 40,
        'next_level2' => 1200*60,
        'is_current' => false,
    ],
    [
        "name" => "LV3",
        'desc' => '三级坐者',
        'next_level1' => 60,
        'next_level2' => 1800*60,
        'is_current' => false,
    ],
    [
        "name" => "LV4",
        'desc' => '四级坐者',
        'next_level1' => 80,
        'next_level2' => 2400*60,
        'is_current' => false,
    ],
    [
        "name" => "LV5",
        'desc' => '五级坐者',
        'next_level1' => 100,
        'next_level2' => 3000*60,
        'is_current' => false,
    ],
];


$config['scores'] = [
    '100' => [120 * 60, 1000000],
    '90' => [90 * 60, 120 * 60],
    '80' => [75 * 60, 90 * 60],
    '70' => [60 * 60, 75 * 60],
    '60' => [30 * 60, 60 * 60],
    '50' => [25 * 60, 30 * 60],
    '40' => [20 * 60, 25 * 60],
    '30' => [15 * 60, 20 * 60],
    '20' => [0, 15 * 60]
];