<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Arr;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        return response()->ajax($positions);
    }

    public function save(Request $request)
    {
        $params = $request->validate([
            'id' => 'nullable|numeric',
            'name' => 'required',
            'is_channel' => 'numeric|in:0,1'
        ]);
        $id = Arr::get($params, 'id', 0);
        // update logic
        if($id){

        }else{
            $data = Arr::only($params, ['name', 'is_channel']);
            $position = Position::create($data);
            return response()->ajax($position);
        }
    }
}
