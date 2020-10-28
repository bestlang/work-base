<?php

use Illuminate\Database\Seeder;

class CmsFieldTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_field_types')->delete();
        
        \DB::table('cms_field_types')->insert(array (
            0 => 
            array (
                'extra' => '{"options":true}',
                'id' => 4,
                'name' => '单选列表',
                'type' => 'select',
            ),
            1 => 
            array (
                'extra' => '{"options":true}',
                'id' => 5,
                'name' => '单选按钮',
                'type' => 'radio',
            ),
            2 => 
            array (
                'extra' => '{"options":false}',
                'id' => 11,
                'name' => '单行文本',
                'type' => 'text',
            ),
            3 => 
            array (
                'extra' => '{"options":false}',
                'id' => 12,
                'name' => '内容',
                'type' => 'content',
            ),
            4 => 
            array (
                'extra' => '{"options":true}',
                'id' => 13,
                'name' => '多选',
                'type' => 'checkbox',
            ),
            5 => 
            array (
                'extra' => '{"options":false}',
                'id' => 14,
                'name' => '单图',
                'type' => 'image',
            ),
            6 => 
            array (
                'extra' => '{"options":false}',
                'id' => 15,
                'name' => '图集',
                'type' => 'multiple-image',
            ),
            7 => 
            array (
                'extra' => '{"options":false}',
                'id' => 16,
                'name' => '附件',
                'type' => 'attachment',
            ),
            8 => 
            array (
                'extra' => '{"options":false}',
                'id' => 17,
                'name' => '标签',
                'type' => 'tags',
            ),
            9 => 
            array (
                'extra' => '{"options":false}',
                'id' => 18,
                'name' => '数值',
                'type' => 'number',
            ),
        ));
        
        
    }
}