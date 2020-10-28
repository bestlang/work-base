<?php

use Illuminate\Database\Seeder;

class SniperEmployeeEducationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sniper_employee_education')->delete();
        
        \DB::table('sniper_employee_education')->insert(array (
            0 => 
            array (
                'created_at' => '2020-09-11 17:20:49',
                'degree' => '学士',
                'end_time' => '2020-12',
                'id' => 1,
                'school' => '哈尔滨工程大学',
                'specialize' => '软件工程',
                'start_time' => '2020-01',
                'unified' => 1,
                'updated_at' => '2020-09-11 18:39:50',
                'user_id' => 190,
            ),
            1 => 
            array (
                'created_at' => '2020-09-11 19:16:55',
                'degree' => '高中',
                'end_time' => '2020-11',
                'id' => 2,
                'school' => '安徽省宿城二中',
                'specialize' => '理工',
                'start_time' => '2020-01',
                'unified' => 1,
                'updated_at' => '2020-09-11 19:17:14',
                'user_id' => 190,
            ),
            2 => 
            array (
                'created_at' => '2020-09-11 19:22:17',
                'degree' => '初中',
                'end_time' => '2016-04',
                'id' => 3,
                'school' => '安徽泗县四山中学',
                'specialize' => '初中',
                'start_time' => '2014-01',
                'unified' => 1,
                'updated_at' => '2020-09-11 19:22:17',
                'user_id' => 190,
            ),
        ));
        
        
    }
}