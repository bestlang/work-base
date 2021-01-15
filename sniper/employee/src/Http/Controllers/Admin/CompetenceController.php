<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Competence\PositionAbilityCategory as PC;
use Arr;

class CompetenceController
{
    public function index(Request $request)
    {
        $position_id = $request->input('position_id');
        if(!!$position_id){
            $catAbilities = PC::where('position_id', $position_id)->with('abilities')->get();
            return response()->ajax($catAbilities);
        }
        return response()->error('参数错误');
    }
    public function categoryAdd(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id');
        $name = Arr::get($params, 'name');
        $position_id = Arr::get($params, 'position_id');
        try{
            if(!!$id && $name){
                $pac = PC::find($id);
                $pac->name = $name;
                $pac->save();
            }else{
                PC::create([
                    'name' => $name,
                    'position_id' => $position_id
                ]);
            }
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax();
    }

    public function categoryDel(Request $request)
    {
        
    }

    public function abilityAdd(Request $request)
    {

    }

    public function abilityDel(Request $request)
    {

    }

}
