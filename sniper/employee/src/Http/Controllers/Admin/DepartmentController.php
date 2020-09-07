<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Department;
use function Sodium\add;
use Illuminate\Database\Eloquent\Collection;

class DepartmentController
{
    public function index(Request $request)
    {
        $departments = Department::all();
        if(!count($departments)){
            $default = new \stdClass();
            $default->id = '0';
            $default->name  = '总公司';
            $departments->push($default);
        }
        $departments->map(function($department){
            $department->label = $department->name;
        });
        return response()->ajax($departments);
    }

    public function save(Request $request)
    {
      $params = $request->all();
    }
}