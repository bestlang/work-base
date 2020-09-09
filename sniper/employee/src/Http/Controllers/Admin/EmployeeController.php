<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Department;
use Sniper\Employee\Models\User;
use Sniper\Employee\Models\Employee;

class EmployeeController
{
    public function departmentEmployee(Request $request)
    {
        $query = Employee::query();
        $departmentId = $request->input('departmentId');
        $departmentIdArr = [];
        $departmentIdArr = Department::find($departmentId)
            ->getDescendantsAndSelf()
            ->map(function($item){return $item->id;})
            ->toArray();
        if(count($departmentIdArr)){
            array_push($departmentIdArr, ...$departmentIdArr);
        }
        $employee = Employee::with(['user', 'position'])->whereIn('department_id', $departmentIdArr)->get();
        return response()->ajax($employee);
    }
    public function save(Request $request)
    {
        $params = $request->all();
        $user = new User;
        $user->name = $params['name'];
        $user->password = bcrypt($params['password']);
        $user->email = $params['email'];
        $user->save();
        $user->employee()->create([
            'real_name' => $params['name'],
            'department_id' => $params['department_id'],
            'position_id' => $params['position_id'],
            'phone' => $params['phone'],
            'gender' => $params['gender'],
            'id_card' => $params['id_card'],
            'avatar' => $params['avatar'],
        ]);
        return response()->ajax($user);
    }
}