<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Competence\Ability;
use Sniper\Employee\Models\Competence\AbilityCategory;
use Sniper\Employee\Models\Competence\PositionAbilityCategory as PAC;
use Sniper\Employee\Models\Position;
use Arr;

class CompetenceController
{
    public function index(Request $request)
    {
        $position_id = $request->input('position_id');
        if(!!$position_id){
            $position = Position::where('id', $position_id)->with('abilityCategories.abilities')->first();
            return response()->ajax($position);
        }
//        if(!!$position_id){
//            $catAbilities = PAC::where('position_id', $position_id)->with('abilities.category')->get();
//            return response()->ajax($catAbilities);
//        }
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
                $pac = PAC::find($id);
                $pac->name = $name;
                $pac->save();
            }else{
                PAC::create([
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
        $id = $request->input('id');
        $ac = AbilityCategory::find($id);
        if($ac){
            $ac->delete();
            return response()->ajax();
        }else{
            return response()->error('记录不存在！');
        }
    }

    public function abilitySave(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id', 0);
        $category_id = Arr::get($params, 'category_id', 0);
        $name = Arr::get($params, 'name', 0);
        $detail = Arr::get($params, 'detail', 0);
        $totalScore = Arr::get($params, 'totalScore', 0);
        $okScore = Arr::get($params, 'okScore', 0);

        $category = PAC::find($category_id);
        if($id){
            $ability = Ability::find($id);
            try {
                $ability->update(['name' => $name, 'detail' => $detail, 'totalScore' => $totalScore, 'okScore' => $okScore]);
            }catch (\Exception $e){
                return response()->error($e->getMessage());
            }
        }else {
            try {
                $category->abilities()->create(['name' => $name, 'detail' => $detail, 'totalScore' => $totalScore, 'okScore' => $okScore]);
            } catch (\Exception $e) {
                return response()->error($e->getMessage());
            }
        }
        return response()->ajax([]);
    }

    public function abilityDel(Request $request)
    {
        $params = $request->all();
        $category_id = Arr::get($params, 'category_id', 0);
        $id = Arr::get($params, 'id', 0);
        $ability = Ability::where('id', $id)->where('category_id', $category_id)->first();
        if($ability){
            $ability->delete();
        }
        return response()->ajax([]);
    }

}
