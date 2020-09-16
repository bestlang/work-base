<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\DingTalk\Department;

class DingTalkController
{
    public function departments(Request $request)
    {
        $departments = Department::all();
        $rootKey = 0;
        foreach ($departments as $key => &$department){
            if(!isset($department->children)){
                $department->children = [];
            }
            if(isset($department->parentid)){
                for($i=0;$i<count($departments); $i++){
                    if($departments[$i]->id == $department->parentid){
                        $children = $departments[$i]->children;
                        $children[] = $department;
                        $departments[$i]->children = $children;
                    }
                }
            }else{
                $rootKey = $key;
            }
        }
        return response()->ajax( $departments[$rootKey] );
    }
}