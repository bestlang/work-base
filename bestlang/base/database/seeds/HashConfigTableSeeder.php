<?php

use Illuminate\Database\Seeder;

class HashConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hash_config')->delete();
        
        \DB::table('hash_config')->insert(array (
            0 => 
            array (
                'created_at' => '2020-08-09 12:45:11',
                'field' => 'title',
                'id' => 12,
                'key' => 'site',
                'updated_at' => '2020-09-24 16:55:19',
                'value' => '这里填一个标题',
            ),
            1 => 
            array (
                'created_at' => '2020-08-09 12:45:11',
                'field' => 'keywords',
                'id' => 13,
                'key' => 'site',
                'updated_at' => '2020-09-24 16:55:19',
                'value' => '这里填一些关键字',
            ),
            2 => 
            array (
                'created_at' => '2020-08-09 12:45:11',
                'field' => 'description',
                'id' => 14,
                'key' => 'site',
                'updated_at' => '2020-09-24 16:55:19',
                'value' => '这里填一些描述',
            ),
            3 => 
            array (
                'created_at' => '2020-08-09 12:45:11',
                'field' => 'theme',
                'id' => 15,
                'key' => 'site',
                'updated_at' => '2020-08-09 12:45:11',
                'value' => 'dark',
            ),
        ));
        
        
    }
}