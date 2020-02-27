<?php
use App\Models\Cms\Content;

// 推荐位函数
if(!function_exists('position')){
    function position($pos){
        $contents = Content::all();
        $contents->map(function($content){
            foreach ($content->metas as $meta){
                $content->{$meta->field} = $meta->value;
            }
            unset($content->metas);
        });
        return $contents;
    }
}