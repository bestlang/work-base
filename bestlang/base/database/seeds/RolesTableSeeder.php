<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'created_at' => '2019-12-29 20:34:42',
                'guard_name' => 'api',
                'id' => 4,
                'name' => '技术人员',
                'updated_at' => '2020-09-21 16:58:12',
            ),
            1 => 
            array (
                'created_at' => '2020-03-16 21:22:17',
                'guard_name' => 'api',
                'id' => 7,
                'name' => 'administrator',
                'updated_at' => '2020-03-16 21:22:17',
            ),
            2 => 
            array (
                'created_at' => '2020-09-21 16:42:15',
                'guard_name' => 'api',
                'id' => 8,
                'name' => '人力资源',
                'updated_at' => '2020-09-21 16:42:15',
            ),
        ));
        
        
    }
}