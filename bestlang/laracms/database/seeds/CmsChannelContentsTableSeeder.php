<?php

use Illuminate\Database\Seeder;

class CmsChannelContentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_channel_contents')->delete();
        
        \DB::table('cms_channel_contents')->insert(array (
            0 => 
            array (
                'channel_id' => 4,
                'field' => 'content',
                'value' => NULL,
            ),
            1 => 
            array (
                'channel_id' => 5,
                'field' => 'content',
                'value' => NULL,
            ),
            2 => 
            array (
                'channel_id' => 6,
                'field' => 'content',
                'value' => NULL,
            ),
            3 => 
            array (
                'channel_id' => 7,
                'field' => 'content',
                'value' => NULL,
            ),
            4 => 
            array (
                'channel_id' => 8,
                'field' => 'content',
                'value' => NULL,
            ),
            5 => 
            array (
                'channel_id' => 9,
                'field' => 'content',
                'value' => NULL,
            ),
            6 => 
            array (
                'channel_id' => 10,
                'field' => 'content',
                'value' => NULL,
            ),
            7 => 
            array (
                'channel_id' => 11,
                'field' => 'content',
                'value' => NULL,
            ),
            8 => 
            array (
                'channel_id' => 12,
                'field' => 'content',
                'value' => NULL,
            ),
            9 => 
            array (
                'channel_id' => 13,
                'field' => 'content',
                'value' => NULL,
            ),
        ));
        
        
    }
}