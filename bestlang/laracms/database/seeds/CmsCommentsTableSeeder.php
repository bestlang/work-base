<?php

use Illuminate\Database\Seeder;

class CmsCommentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_comments')->delete();
        
        \DB::table('cms_comments')->insert(array (
            0 => 
            array (
                'content' => '11111111111111111',
                'content_id' => 4,
                'created_at' => '2020-02-28 14:37:06',
                'deleted_at' => NULL,
                'id' => 6,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-02-28 14:37:06',
                'user_id' => 3,
            ),
            1 => 
            array (
                'content' => '22222222222',
                'content_id' => 4,
                'created_at' => '2020-02-28 14:37:32',
                'deleted_at' => NULL,
                'id' => 7,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-02-28 14:37:32',
                'user_id' => 3,
            ),
            2 => 
            array (
                'content' => '我曹 无情',
                'content_id' => 4,
                'created_at' => '2020-02-28 23:06:59',
                'deleted_at' => NULL,
                'id' => 8,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-02-28 23:06:59',
                'user_id' => 3,
            ),
            3 => 
            array (
                'content' => '你还好吗',
                'content_id' => 4,
                'created_at' => '2020-02-28 23:07:31',
                'deleted_at' => NULL,
                'id' => 9,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-02-28 23:07:31',
                'user_id' => 3,
            ),
            4 => 
            array (
                'content' => '3123123123',
                'content_id' => 2,
                'created_at' => '2020-02-28 23:49:30',
                'deleted_at' => NULL,
                'id' => 10,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-02-28 23:49:30',
                'user_id' => 3,
            ),
            5 => 
            array (
                'content' => '123123123123123123',
                'content_id' => 2,
                'created_at' => '2020-02-28 23:49:33',
                'deleted_at' => NULL,
                'id' => 11,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-02-28 23:49:33',
                'user_id' => 3,
            ),
            6 => 
            array (
                'content' => '618周四',
                'content_id' => 2,
                'created_at' => '2020-06-18 17:52:11',
                'deleted_at' => NULL,
                'id' => 12,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-06-18 17:52:11',
                'user_id' => 3,
            ),
            7 => 
            array (
                'content' => '2020活着就好',
                'content_id' => 4,
                'created_at' => '2020-06-18 17:54:35',
                'deleted_at' => NULL,
                'id' => 13,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-06-18 17:54:35',
                'user_id' => 3,
            ),
            8 => 
            array (
                'content' => 'asdasdasd',
                'content_id' => 60,
                'created_at' => '2020-07-11 20:05:19',
                'deleted_at' => NULL,
                'id' => 14,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-07-11 20:05:19',
                'user_id' => 3,
            ),
            9 => 
            array (
                'content' => 'fuck',
                'content_id' => 60,
                'created_at' => '2020-07-11 20:05:33',
                'deleted_at' => NULL,
                'id' => 15,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-07-11 20:05:33',
                'user_id' => 3,
            ),
            10 => 
            array (
                'content' => 'fuck two',
                'content_id' => 60,
                'created_at' => '2020-07-11 20:05:41',
                'deleted_at' => NULL,
                'id' => 16,
                'ip' => NULL,
                'parent_id' => 0,
                'updated_at' => '2020-07-11 20:05:41',
                'user_id' => 3,
            ),
        ));
        
        
    }
}