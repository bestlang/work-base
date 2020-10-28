<?php

use Illuminate\Database\Seeder;

class CmsPositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_positions')->delete();
        
        \DB::table('cms_positions')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'id' => 1,
                'is_channel' => 0,
                'name' => '第一个推荐位',
                'order_factor' => 100,
                'parent_id' => 0,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => '2020-02-18 22:39:23',
                'id' => 2,
                'is_channel' => 1,
                'name' => '首页栏目推荐',
                'order_factor' => 100,
                'parent_id' => 0,
                'updated_at' => '2020-02-18 22:39:23',
            ),
            2 => 
            array (
                'created_at' => '2020-02-18 22:40:30',
                'id' => 3,
                'is_channel' => 0,
                'name' => '热点文章推荐',
                'order_factor' => 100,
                'parent_id' => 0,
                'updated_at' => '2020-02-18 22:40:30',
            ),
            3 => 
            array (
                'created_at' => '2020-02-19 22:49:14',
                'id' => 4,
                'is_channel' => 0,
                'name' => '大图推荐',
                'order_factor' => 100,
                'parent_id' => 2,
                'updated_at' => '2020-03-30 22:46:02',
            ),
            4 => 
            array (
                'created_at' => '2020-02-19 23:11:05',
                'id' => 5,
                'is_channel' => 0,
                'name' => '默认推荐',
                'order_factor' => 100,
                'parent_id' => 2,
                'updated_at' => '2020-03-30 22:46:09',
            ),
            5 => 
            array (
                'created_at' => '2020-02-22 13:25:52',
                'id' => 6,
                'is_channel' => 1,
                'name' => '第二个栏目推荐位',
                'order_factor' => 100,
                'parent_id' => 0,
                'updated_at' => '2020-09-21 16:20:30',
            ),
            6 => 
            array (
                'created_at' => '2020-02-22 13:26:27',
                'id' => 7,
                'is_channel' => 0,
                'name' => '默认',
                'order_factor' => 100,
                'parent_id' => 6,
                'updated_at' => '2020-02-22 13:26:27',
            ),
            7 => 
            array (
                'created_at' => '2020-05-16 12:01:25',
                'id' => 8,
                'is_channel' => 0,
                'name' => '文章详情右侧推荐一',
                'order_factor' => 100,
                'parent_id' => 0,
                'updated_at' => '2020-05-16 12:01:25',
            ),
            8 => 
            array (
                'created_at' => '2020-06-03 08:33:23',
                'id' => 9,
                'is_channel' => 0,
                'name' => '首页图集推荐',
                'order_factor' => 100,
                'parent_id' => 0,
                'updated_at' => '2020-06-03 08:33:23',
            ),
        ));
        
        
    }
}