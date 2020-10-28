<?php

use Illuminate\Database\Seeder;

class CmsModelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cms_models')->delete();
        
        \DB::table('cms_models')->insert(array (
            0 => 
            array (
                'created_at' => '2020-02-08 20:16:22',
                'deleted_at' => NULL,
                'has_contents' => 1,
                'id' => 1,
                'name' => '新闻模型',
                'status' => 1,
                'template_prefix' => 'models.news',
                'updated_at' => '2020-09-01 19:06:18',
            ),
            1 => 
            array (
                'created_at' => '2020-02-14 12:16:35',
                'deleted_at' => NULL,
                'has_contents' => 1,
                'id' => 2,
                'name' => '图片模型',
                'status' => 1,
                'template_prefix' => 'models.images',
                'updated_at' => '2020-08-06 16:40:07',
            ),
            2 => 
            array (
                'created_at' => '2020-03-22 09:22:17',
                'deleted_at' => NULL,
                'has_contents' => 1,
                'id' => 3,
                'name' => '下载模型',
                'status' => 1,
                'template_prefix' => 'models.downloads',
                'updated_at' => '2020-08-06 22:07:34',
            ),
            3 => 
            array (
                'created_at' => '2020-03-22 09:32:22',
                'deleted_at' => NULL,
                'has_contents' => 0,
                'id' => 4,
                'name' => '单页模型',
                'status' => 1,
                'template_prefix' => 'models.single',
                'updated_at' => '2020-08-06 16:40:44',
            ),
            4 => 
            array (
                'created_at' => '2020-06-04 10:49:22',
                'deleted_at' => NULL,
                'has_contents' => 1,
                'id' => 5,
                'name' => '轮播图',
                'status' => 1,
                'template_prefix' => NULL,
                'updated_at' => '2020-06-04 10:49:22',
            ),
            5 => 
            array (
                'created_at' => '2020-07-03 16:39:15',
                'deleted_at' => NULL,
                'has_contents' => 1,
                'id' => 6,
                'name' => '商品模型',
                'status' => 1,
                'template_prefix' => 'models.products',
                'updated_at' => '2020-08-06 22:07:40',
            ),
        ));
        
        
    }
}