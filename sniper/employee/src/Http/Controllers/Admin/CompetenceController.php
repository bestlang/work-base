<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Competence\Ability;
use Sniper\Employee\Models\Competence\AbilityCategory;
use Sniper\Employee\Models\Competence\PositionAbilityCategory as PAC;
use Sniper\Employee\Models\Position;
use Sniper\Employee\Models\Competence\EmployeeAbilityScore;

use Arr;

class CompetenceController
{
    public function employeeScore(Request $request)
    {
        $params = $request->all();
        $user_id = Arr::get($params, 'user_id', 0);
        $position_id = Arr::get($params, 'position_id', 0);
        $scores = EmployeeAbilityScore::where([['user_id', $user_id],['position_id', $position_id]])->get();
        return response()->ajax($scores);
    }
    //员工胜任力
    public function employee(Request $request)
    {
        $params = $request->all();
        $user_id = Arr::get($params, 'user_id', 0);
        $position_id = Arr::get($params, 'position_id', 0);
        $abilities = Arr::get($params, 'abilities', 0);
        $condition = ['user_id' => $user_id, 'position_id' => $position_id];
        $pattern = "/category_(\d+)_ability_(\d+)/";
        $tmpAbilities = Ability::all();
        $abilityMap = [];
        foreach ($tmpAbilities as $ta){
            $abilityMap[$ta->category_id][$ta->id] = $ta;
        }
        try {
            foreach ($abilities as $key => $score) {
                if (preg_match($pattern, $key, $matches)) {
                    if (($category_id = $matches[1]) && ($ability_id = $matches[2])) {
                        $condition['ability_category_id'] = $category_id;
                        $condition['ability_id'] = $ability_id;
                        $arr = [];
                        $arr['score'] = intval($score);
                        $arr['name'] = $abilityMap[$category_id][$ability_id]->name;
                        $arr['detail'] = $abilityMap[$category_id][$ability_id]->detail;
                        $arr['totalScore'] = $abilityMap[$category_id][$ability_id]->totalScore;
                        $arr['okScore'] = $abilityMap[$category_id][$ability_id]->okScore;
                        if($arr['totalScore'] < $arr['score']){
                            throw new \Exception('得分不能大于总分值');
                        }
                        if($arr['score'] <=0){
                            throw new \Exception('得分必须大于0');
                        }
                        EmployeeAbilityScore::updateOrCreate(['user_id' => $user_id, 'position_id' => $position_id, 'ability_category_id' => $category_id, 'ability_id' => $ability_id], $arr);
                    }
                }
            }
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax([]);
    }

    public function index(Request $request)
    {
        $position_id = $request->input('position_id');
        if(!!$position_id){
            $position = Position::where('id', $position_id)->with('abilityCategories.abilities')->first();
            return response()->ajax($position);
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
