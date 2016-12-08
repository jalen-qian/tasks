<?php
/**
* 测试
* @author wenjun qian
* @date 2016/12/8
*/
echo "<pre>";
$data = [
    [
        'id'         => 1,
        'hotel_name' => '长隆酒店',
        'ac_list'    => [
            [
                'id'        => 1,
                'image_url' => 'http://www.baidu.com',
            ],
            [
                'id'        => 2,
                'image_url' => 'http://www.jd.com',
            ],

        ],
    ],
    [
        'id'         => 2,
        'hotel_name' => '万达酒店',
        'ac_list'    => [
            [
                'id'        => 1,
                'image_url' => 'http://www.taobao.com',
            ],
            [
                'id'        => 2,
                'image_url' => 'http://www.wangyi.com',
            ],

        ],
    ],

];
$data2 =  [
    [
        'id'   => 1,
        'hotelName' => '长隆酒店',
        'date'      => '2016-12-06',
        'isOpen'    => 1,
    ],
    [
        'id'   => 1,
        'hotelName' => '长隆酒店',
        'date'      => '2016-12-07',
        'isOpen'    => 0,
    ],
    [
        'id'   => 1,
        'hotelName' => '长隆酒店',
        'date'      => '2016-12-08',
        'isOpen'    => 1,
    ],
    [
        'id'   => 1,
        'hotelName' => '长隆酒店',
        'date'      => '2016-12-09',
        'isOpen'    => 0,
    ],

];

$data3 = [
    [
        'id'        => 1,
        'hotelName' => '长隆酒店',
        'dateList'    => [
            [
                'date'   => '2016-12-06',
                'isOpen' => 1,
            ],
            [
                'date'   => '2016-12-07',
                'isOpen' =>0,
            ],
            [
                'date'   => '2016-12-08',
                'isOpen' => 1,
            ],
            [
                'date'   => '2016-12-09',
                'isOpen' => 0,
            ],
        ],
    ],

];

$data4 =  [
    [
        'id'           => 1,
        'hotelName'    => '长隆酒店',
        'styleId'      => 3,
        'styleName'    => "三选一",
        'itemId'       => 333,
        'itemName'     => '双早元素',
        'providerId'   => 333,
        'providerName' => '长隆供应商',

    ],
    [
        'id'           => 2,
        'hotelName'    => '七天酒店',
        'styleId'      => 4,
        'styleName'    => "四选一",
        'itemId'       => 444,
        'itemName'     => '单早元素',
        'providerId'   => 444,
        'providerName' => '七天供应商',
    ],
];


include "ArrayTrans.php";
$transform = new ArrayTransform();
$data = $transform -> transformOne($data);
echo "第一题：<br>";
print_r ($data);   


$data2 = $transform -> transformTwo($data2);
echo "<br><br>第二题：<br>";
print_r($data2);

$data3 = $transform -> transformThree($data3);
echo "<br><br>第三题：<br>";
print_r($data3);

$data4 = $transform -> transformFour($data4);
echo "<br><br>第四题：<br>";
print_r($data4);




