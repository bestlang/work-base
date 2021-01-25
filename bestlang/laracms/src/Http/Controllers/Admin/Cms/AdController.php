<?php
namespace BestLang\LaraCMS\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use BestLang\LaraCMS\Http\Controllers\Controller;
use BestLang\LaraCMS\Models\Cms\Ad;
use BestLang\LaraCMS\Models\Cms\AdPosition;
use Illuminate\Support\Arr;
use Validator;

class AdController extends Controller
{
    // 广告位-------------
    public function saveAdPosition(Request $request)
    {
        $params = $request->only(['name', 'enabled', 'description']);
        $rules = [
            'name' => 'required',
        ];
        $infos = [
            'name.required' => '名称不能为空',
        ];
        $names = [
            'name' => '名称',
        ];
        $validator = Validator::make($params, $rules, $infos, $names);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        if($id = $request->input('id', 0)){
            AdPosition::where('id', $id)->update($params);
        }else{
            try{
                AdPosition::create($params);
            }catch (\Exception $e){
                return response()->error($e->getMessage());
            }
        }
        return response()->ajax();
    }

    public function getAdPositions(Request $request)
    {
        return response()->ajax(AdPosition::all());
    }

    public function getAd(Request $request)
    {
        $id = $request->input('id', 0);
        $ad = Ad::find($id);
        return response()->ajax($ad);
    }

    public function deleteAdPosition(Request $request)
    {
        $id = $request->input('id', 0);
        if($id){
            $position = AdPosition::find($id);
            if($position->ads()->count()){
                return response()->error('该广告位下仍然有广告, 无法删除!');
            }
            try{
                AdPosition::where('id', $id)->delete();
            }catch (\Exception $e){
                return response()->error($e->getMessage());
            }
        }
        return response()->ajax();
    }
    // -------------广告位

    // 广告-------------

    public function getAds(Request $request)
    {
        return response()->ajax(Ad::with('position')->orderBy('id', 'desc')->get());
    }

    public function saveAd(Request $request)
    {
        $type = $request->input('type', 1);
        $type = intval($type);

        $id = $request->input('id', 0);
        $id = intval($id);

        $allRules = [
            'name' => 'required',
            'position_id' => 'exists:cms_ad_positions,id',
            'enabled' => 'in:0,1',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'url' => 'required',
            'image' => 'required',
            'tiny_image' => 'nullable',
            'target' => 'in:_black,_self',

            'text' => 'required',
            'code' => 'required'
        ];

        if($type == 1){ // 图片广告
            $params = $request->only(['name', 'position_id', 'enabled', 'start_time', 'end_time', 'type', 'url', 'image', 'tiny_image', 'target']);
            $rules = Arr::only($allRules, ['name','position_id','enabled','start_time','end_time','url','image','tiny_image','target']);
            $validator = Validator::make($params, $rules);
            if($validator->fails()){
                return response()->error($validator->errors()->first());
            }

        }else if($type == 2){ // 文字广告
            $params = $request->only(['name', 'position_id', 'enabled', 'start_time', 'end_time', 'type', 'url', 'text', 'target']);
            $rules = Arr::only($allRules, ['name','position_id','enabled','start_time','end_time','url', 'text', 'target']);
            $validator = Validator::make($params, $rules);
            if($validator->fails()){
                return response()->error($validator->errors()->first());
            }
        }else if($type == 3){ // 代码广告
            $params = $request->only(['name', 'position_id', 'enabled', 'start_time', 'end_time', 'type', 'url', 'code', 'target']);
            $rules = Arr::only($allRules, ['name','position_id','enabled','start_time','end_time','url', 'code', 'target']);
            $validator = Validator::make($params, $rules);
            if($validator->fails()){
                return response()->error($validator->errors()->first());
            }
        }
        // 插入 || 更新
        try{
            if($id){
                Ad::where('id', $id)->update($params);
            }else{
                Ad::create($params);
            }
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax();

    }

    public function deleteAd(Request $request)
    {
        $id = $request->input('id', 0);
        if($id){
            Ad::where('id', $id)->delete();
        }
        return response()->ajax();
    }
    // -------------广告
}