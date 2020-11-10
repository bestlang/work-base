<?php

use Illuminate\Database\Seeder;

class CmsAdsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_ads')->delete();
        
        \DB::table('cms_ads')->insert(array (
            0 => 
            array (
                'code' => NULL,
                'created_at' => '2020-06-06 14:57:27',
                'enabled' => 1,
                'end_time' => '2020-06-06 02:02:02',
                'id' => 4,
                'image' => 'https://static.laracms.com/uploads/720305.png',
                'name' => '首页右侧第一个广告位-1',
                'position_id' => 3,
                'start_time' => '2020-06-01 02:02:02',
                'target' => '_black',
                'text' => NULL,
                'tiny_image' => NULL,
                'type' => 1,
                'updated_at' => '2020-06-07 11:19:50',
                'url' => 'http://www.baidu.com',
            ),
            1 => 
            array (
                'code' => NULL,
                'created_at' => '2020-06-06 15:00:47',
                'enabled' => 1,
                'end_time' => '2021-07-30 22:00:00',
                'id' => 5,
                'image' => 'https://static.laracms.com/uploads/720305-1.png',
                'name' => '首页右侧第一个广告位-2',
                'position_id' => 3,
                'start_time' => '2020-06-01 02:00:00',
                'target' => '_black',
                'text' => NULL,
                'tiny_image' => 'https://static.laracms.com/uploads/home-select-fill2.png',
                'type' => 1,
                'updated_at' => '2020-06-07 10:38:16',
                'url' => 'http://www.yahoo.co.jp',
            ),
        ));
        
        
    }
}