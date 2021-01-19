<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\User;
use Sniper\Employee\Models\Employee;
use Sniper\Employee\Models\Position;

class SubordinateController
{
    public function index(Request $request)
    {
        $user = auth()->user();// instanceof BestLang\Base\Models\User
        $user = User::where('email', 'shengguangji@sniper-tech.com')->first();
        $currentEmployee = Employee::with('position')->where('user_id', $user->id)->first();
        if($currentEmployee->position){
            $position_id = $currentEmployee->position->id;
            $positionIds = Position::where('parent_id', $position_id)->pluck('id')->toArray();
            $employee = Employee::whereIn('position_id', $positionIds)->with('user')->get();
            return response()->ajax($employee);
        }else{
            return response()->ajax([]);
        }
    }
}
