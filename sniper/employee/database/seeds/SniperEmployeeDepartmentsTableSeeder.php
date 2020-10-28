<?php

use Illuminate\Database\Seeder;

class SniperEmployeeDepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sniper_employee_departments')->delete();
        
        \DB::table('sniper_employee_departments')->insert(array (
            0 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 0,
                'id' => 1,
                'left' => 1,
                'manager' => NULL,
            'name' => '思纳福(北京)医疗科技有限公司',
                'parent_id' => NULL,
                'right' => 38,
                'updated_at' => '2020-10-09 10:45:54',
            ),
            1 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116359451,
                'left' => 2,
                'manager' => NULL,
                'name' => '总经办',
                'parent_id' => 1,
                'right' => 3,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            2 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375312,
                'left' => 4,
                'manager' => NULL,
                'name' => '财务部',
                'parent_id' => 1,
                'right' => 5,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            3 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375314,
                'left' => 6,
                'manager' => NULL,
                'name' => '人事行政部',
                'parent_id' => 1,
                'right' => 7,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            4 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375315,
                'left' => 8,
                'manager' => NULL,
                'name' => '采购库管部',
                'parent_id' => 1,
                'right' => 9,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            5 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375316,
                'left' => 10,
                'manager' => NULL,
                'name' => '市场部',
                'parent_id' => 1,
                'right' => 11,
                'updated_at' => '2020-09-22 17:16:20',
            ),
            6 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375317,
                'left' => 12,
                'manager' => NULL,
                'name' => '质量部',
                'parent_id' => 1,
                'right' => 13,
                'updated_at' => '2020-09-22 17:23:59',
            ),
            7 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375320,
                'left' => 14,
                'manager' => NULL,
                'name' => '应用开发部',
                'parent_id' => 1,
                'right' => 15,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            8 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375321,
                'left' => 16,
                'manager' => NULL,
                'name' => '产品研发事业部',
                'parent_id' => 1,
                'right' => 29,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            9 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 2,
                'id' => 116375322,
                'left' => 17,
                'manager' => NULL,
                'name' => '电子学开发组',
                'parent_id' => 116375321,
                'right' => 18,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            10 => 
            array (
                'created_at' => '2020-09-18 11:46:14',
                'deleted_at' => NULL,
                'depth' => 2,
                'id' => 116375323,
                'left' => 19,
                'manager' => NULL,
                'name' => '软件开发组',
                'parent_id' => 116375321,
                'right' => 20,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            11 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 2,
                'id' => 116375326,
                'left' => 21,
                'manager' => NULL,
                'name' => '测试组',
                'parent_id' => 116375321,
                'right' => 22,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            12 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 2,
                'id' => 116375327,
                'left' => 23,
                'manager' => NULL,
                'name' => '加工组',
                'parent_id' => 116375321,
                'right' => 24,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            13 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 116375328,
                'left' => 30,
                'manager' => NULL,
                'name' => '新技术预研部',
                'parent_id' => 1,
                'right' => 31,
                'updated_at' => '2020-09-25 15:09:01',
            ),
            14 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 2,
                'id' => 116425477,
                'left' => 25,
                'manager' => NULL,
                'name' => '机械设计组',
                'parent_id' => 116375321,
                'right' => 26,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            15 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 122334329,
                'left' => 32,
                'manager' => NULL,
                'name' => '后勤',
                'parent_id' => 1,
                'right' => 33,
                'updated_at' => '2020-09-25 15:09:01',
            ),
            16 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 126292488,
                'left' => 34,
                'manager' => NULL,
                'name' => '生产部',
                'parent_id' => 1,
                'right' => 35,
                'updated_at' => '2020-09-25 15:09:01',
            ),
            17 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 2,
                'id' => 141958379,
                'left' => 27,
                'manager' => NULL,
                'name' => '中试组',
                'parent_id' => 116375321,
                'right' => 28,
                'updated_at' => '2020-09-18 11:47:07',
            ),
            18 => 
            array (
                'created_at' => '2020-09-18 11:46:15',
                'deleted_at' => NULL,
                'depth' => 1,
                'id' => 227704133,
                'left' => 36,
                'manager' => NULL,
                'name' => '品牌部',
                'parent_id' => 1,
                'right' => 37,
                'updated_at' => '2020-09-25 15:09:01',
            ),
        ));
        
        
    }
}