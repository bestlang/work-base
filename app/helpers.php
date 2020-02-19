<?php
use App\Models\Cms\Content;

// 推荐位函数
if(!function_exists('position')){
    function position($pos){
        return Content::all();
    }
}