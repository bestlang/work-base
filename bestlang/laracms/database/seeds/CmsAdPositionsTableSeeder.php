<?php

use Illuminate\Database\Seeder;

class CmsAdPositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_ad_positions')->delete();
        
        \DB::table('cms_ad_positions')->insert(array (
            0 => 
            array (
                'created_at' => '2020-06-05 11:28:24',
                'deleted_at' => NULL,
                'description' => '首页右第一个推荐位1.0',
                'enabled' => 1,
                'id' => 3,
                'name' => '首页右第一个广告位',
                'order_factor' => 0,
                'updated_at' => '2020-06-07 10:08:13',
            ),
            1 => 
            array (
                'created_at' => '2020-06-05 11:28:36',
                'deleted_at' => NULL,
                'description' => '首页右第二个广告位',
                'enabled' => 1,
                'id' => 4,
                'name' => '首页右第二个广告位',
                'order_factor' => 0,
                'updated_at' => '2020-06-06 21:59:17',
            ),
        ));
        
        
    }
}