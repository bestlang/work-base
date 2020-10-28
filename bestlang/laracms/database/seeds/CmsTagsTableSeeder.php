<?php

use Illuminate\Database\Seeder;

class CmsTagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_tags')->delete();
        
        \DB::table('cms_tags')->insert(array (
            0 => 
            array (
                'created_at' => '2020-06-16 22:47:55',
                'id' => 1,
                'name' => '111',
                'updated_at' => '2020-06-16 22:47:55',
            ),
            1 => 
            array (
                'created_at' => '2020-06-16 22:47:55',
                'id' => 2,
                'name' => '222',
                'updated_at' => '2020-06-16 22:47:55',
            ),
            2 => 
            array (
                'created_at' => '2020-06-16 22:47:55',
                'id' => 3,
                'name' => '333',
                'updated_at' => '2020-06-16 22:47:55',
            ),
            3 => 
            array (
                'created_at' => '2020-06-16 22:55:28',
                'id' => 4,
                'name' => '4444',
                'updated_at' => '2020-06-16 22:55:28',
            ),
            4 => 
            array (
                'created_at' => '2020-06-16 23:15:52',
                'id' => 5,
                'name' => '5555',
                'updated_at' => '2020-06-16 23:15:52',
            ),
            5 => 
            array (
                'created_at' => '2020-06-17 10:24:08',
                'id' => 6,
                'name' => '555',
                'updated_at' => '2020-06-17 10:24:08',
            ),
            6 => 
            array (
                'created_at' => '2020-06-17 10:59:20',
                'id' => 7,
                'name' => '123123',
                'updated_at' => '2020-06-17 10:59:20',
            ),
            7 => 
            array (
                'created_at' => '2020-06-17 21:59:22',
                'id' => 8,
                'name' => 'aaaa',
                'updated_at' => '2020-06-17 21:59:22',
            ),
            8 => 
            array (
                'created_at' => '2020-06-17 21:59:22',
                'id' => 9,
                'name' => 'bbbb',
                'updated_at' => '2020-06-17 21:59:22',
            ),
            9 => 
            array (
                'created_at' => '2020-06-17 21:59:22',
                'id' => 10,
                'name' => 'cccc',
                'updated_at' => '2020-06-17 21:59:22',
            ),
            10 => 
            array (
                'created_at' => '2020-06-17 21:59:41',
                'id' => 11,
                'name' => 'ddd',
                'updated_at' => '2020-06-17 21:59:41',
            ),
            11 => 
            array (
                'created_at' => '2020-06-17 21:59:41',
                'id' => 12,
                'name' => 'eeee',
                'updated_at' => '2020-06-17 21:59:41',
            ),
            12 => 
            array (
                'created_at' => '2020-06-17 22:08:20',
                'id' => 13,
                'name' => '新冠肺炎',
                'updated_at' => '2020-06-17 22:08:20',
            ),
            13 => 
            array (
                'created_at' => '2020-06-17 22:08:20',
                'id' => 14,
                'name' => '私人飞机',
                'updated_at' => '2020-06-17 22:08:20',
            ),
            14 => 
            array (
                'created_at' => '2020-06-17 22:08:20',
                'id' => 15,
                'name' => '滴滴出行',
                'updated_at' => '2020-06-17 22:08:20',
            ),
            15 => 
            array (
                'created_at' => '2020-06-17 22:25:49',
                'id' => 16,
                'name' => '肺炎',
                'updated_at' => '2020-06-17 22:25:49',
            ),
            16 => 
            array (
                'created_at' => '2020-06-17 22:26:20',
                'id' => 17,
                'name' => 'WIFI',
                'updated_at' => '2020-06-17 22:26:20',
            ),
            17 => 
            array (
                'created_at' => '2020-06-17 22:26:30',
                'id' => 18,
                'name' => '干货整理',
                'updated_at' => '2020-06-17 22:26:30',
            ),
            18 => 
            array (
                'created_at' => '2020-06-17 22:27:54',
                'id' => 19,
                'name' => '起名字',
                'updated_at' => '2020-06-17 22:27:54',
            ),
            19 => 
            array (
                'created_at' => '2020-06-17 22:27:54',
                'id' => 20,
                'name' => '性感',
                'updated_at' => '2020-06-17 22:27:54',
            ),
            20 => 
            array (
                'created_at' => '2020-06-17 22:27:54',
                'id' => 21,
                'name' => '撩骚',
                'updated_at' => '2020-06-17 22:27:54',
            ),
            21 => 
            array (
                'created_at' => '2020-06-17 22:28:10',
                'id' => 22,
                'name' => '房地产',
                'updated_at' => '2020-06-17 22:28:10',
            ),
            22 => 
            array (
                'created_at' => '2020-06-17 22:28:10',
                'id' => 23,
                'name' => 'money',
                'updated_at' => '2020-06-17 22:28:10',
            ),
            23 => 
            array (
                'created_at' => '2020-06-17 22:28:48',
                'id' => 24,
                'name' => '抖音',
                'updated_at' => '2020-06-17 22:28:48',
            ),
            24 => 
            array (
                'created_at' => '2020-06-17 22:28:48',
                'id' => 25,
                'name' => '快手',
                'updated_at' => '2020-06-17 22:28:48',
            ),
            25 => 
            array (
                'created_at' => '2020-06-17 22:28:48',
                'id' => 26,
                'name' => '短视频',
                'updated_at' => '2020-06-17 22:28:48',
            ),
            26 => 
            array (
                'created_at' => '2020-06-18 09:19:12',
                'id' => 27,
                'name' => '五花八门',
                'updated_at' => '2020-06-18 09:19:12',
            ),
            27 => 
            array (
                'created_at' => '2020-06-18 09:19:12',
                'id' => 28,
                'name' => '洪福齐天',
                'updated_at' => '2020-06-18 09:19:12',
            ),
            28 => 
            array (
                'created_at' => '2020-06-18 09:19:12',
                'id' => 29,
                'name' => '天网恢恢',
                'updated_at' => '2020-06-18 09:19:12',
            ),
            29 => 
            array (
                'created_at' => '2020-06-19 16:47:52',
                'id' => 30,
                'name' => 'ss',
                'updated_at' => '2020-06-19 16:47:52',
            ),
            30 => 
            array (
                'created_at' => '2020-06-19 17:29:37',
                'id' => 31,
                'name' => '大蒜',
                'updated_at' => '2020-06-19 17:29:37',
            ),
            31 => 
            array (
                'created_at' => '2020-06-21 20:08:04',
                'id' => 32,
                'name' => '蒜你狠',
                'updated_at' => '2020-06-21 20:08:04',
            ),
            32 => 
            array (
                'created_at' => '2020-06-21 20:08:04',
                'id' => 33,
                'name' => 'PHP',
                'updated_at' => '2020-06-21 20:08:04',
            ),
            33 => 
            array (
                'created_at' => '2020-06-23 11:53:19',
                'id' => 34,
                'name' => '非洲的树',
                'updated_at' => '2020-06-23 11:53:19',
            ),
            34 => 
            array (
                'created_at' => '2020-06-23 11:53:31',
                'id' => 35,
                'name' => '大海深处',
                'updated_at' => '2020-06-23 11:53:31',
            ),
            35 => 
            array (
                'created_at' => '2020-06-23 11:53:58',
                'id' => 36,
                'name' => '落日黄昏',
                'updated_at' => '2020-06-23 11:53:58',
            ),
            36 => 
            array (
                'created_at' => '2020-06-23 11:54:20',
                'id' => 37,
                'name' => '静谧冬夜',
                'updated_at' => '2020-06-23 11:54:20',
            ),
        ));
        
        
    }
}