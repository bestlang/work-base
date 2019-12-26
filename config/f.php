<?php

return [
    'F_A' => env('F_A', 0.5), // 直接购买返佣比例
    'F_B' => env('F_B', 0.2), // 下级购买返佣比例
    'F_C' => env('F_C', 0.0),  // 间接下级购买返佣比例
    'F_THRESHOLD' => env('F_THRESHOLD', 200) // 全返阈值:以分为单位
];