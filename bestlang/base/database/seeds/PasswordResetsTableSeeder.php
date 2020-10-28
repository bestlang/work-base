<?php

use Illuminate\Database\Seeder;

class PasswordResetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('password_resets')->delete();
        
        \DB::table('password_resets')->insert(array (
            0 => 
            array (
                'created_at' => '2020-09-02 12:53:40',
                'email' => 'luzhang987@163.com',
                'token' => '$2y$10$IDyOVONIw6c1yI2fg0sMcumC4XVNxsErM.8EVE2xZwXMIJjVP4aOm',
            ),
            1 => 
            array (
                'created_at' => '2020-10-22 19:04:42',
                'email' => 'luzhang@sniper-tech.com',
                'token' => '$2y$10$2Q7WdJKxiZ8z5908EQY0Xu/FeJX8LCiq9oygI4HR0F5uu50P7Ld96',
            ),
        ));
        
        
    }
}