<?php

use Illuminate\Database\Seeder;

class SniperEmployeeJobsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sniper_employee_jobs')->delete();
        
        \DB::table('sniper_employee_jobs')->insert(array (
            0 => 
            array (
                'company' => '苏州昂生网络科技有限公司',
                'created_at' => '2020-09-14 11:23:22',
                'end_time' => '2020-09',
                'id' => 1,
                'position' => '技术经理',
                'reason' => '解散1111',
                'salary' => '16500.00',
                'start_time' => '2019-01',
                'updated_at' => '2020-09-14 13:43:52',
                'user_id' => 190,
                'witness_phone' => '19847382757',
            ),
            1 => 
            array (
                'company' => '华为',
                'created_at' => '2020-09-16 09:20:41',
                'end_time' => '2020-07',
                'id' => 3,
                'position' => '测试',
                'reason' => NULL,
                'salary' => '1000.00',
                'start_time' => '2020-01',
                'updated_at' => '2020-09-16 09:20:41',
                'user_id' => 190,
                'witness_phone' => NULL,
            ),
        ));
        
        
    }
}