<?php

use Illuminate\Database\Seeder;

class CmsPositionChannelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_position_channels')->delete();
        
        \DB::table('cms_position_channels')->insert(array (
            0 => 
            array (
                'channel_id' => 7,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'channel_id' => 17,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'channel_id' => 7,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 6,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'channel_id' => 17,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 6,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'channel_id' => 24,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 6,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'channel_id' => 15,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'channel_id' => 10,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'channel_id' => 20,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 6,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'channel_id' => 18,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'channel_id' => 16,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 6,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'channel_id' => 9,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'channel_id' => 8,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 6,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'channel_id' => 19,
                'created_at' => NULL,
                'deleted_at' => NULL,
                'order_factor' => 100,
                'position_id' => 2,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}