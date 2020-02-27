<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Channel;
use App\Models\Cms\Position;
use App\Models\Cms\PositionContent;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Arr;

class PositionController extends Controller
{
    // 获取一级推荐位(排除子推荐位)
    public function index(Request $request)
    {
        $is_channel = $request->input('is_channel', -1);
        $is_channel = intval($is_channel);
        $query = Position::query();
        $query->where('parent_id', 0);
        if($is_channel !== -1){
            $query->where('is_channel', $is_channel);
        }
        $positions = $query->orderBy('is_channel', 'desc')->orderBy('id', 'desc')->get();
        return response()->ajax($positions);
    }

    public function contentPositions(Request $request)
    {
        // 栏目推荐位 + 通用内容推荐位

        $params = $request->validate([
            'channel_id' => 'required|numeric',
        ]);
        try{
            $showPositions = [];
            $channel = Channel::findOrFail($params['channel_id']);
            $positions = $channel->positions;
            $positions->each(function($position)use($channel, &$showPositions){
                $position->subs->each(function($sub)use($position, $channel, &$showPositions){
                    $sub->name = $position->name.'-'.$channel->name.'-'.$sub->name;
                    array_push($showPositions, $sub);
                });

            });
            $contentPositions = Position::where('is_channel', 0)->where('parent_id', 0)->get();
            return response()->ajax(collect($showPositions)->merge($contentPositions));
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
    }

    public function save(Request $request)
    {
        $params = $request->validate([
            'id' => 'nullable|numeric',
            'name' => 'required',
            'is_channel' => 'numeric|in:0,1',
            'parent_id' => 'nullable|numeric'
        ]);
        $id = Arr::get($params, 'id', 0);
        // update logic
        if($id){
            $position = Position::find($id);
            $data = Arr::only($params, ['name', 'order_factor']);
            $position->update($data);
            return response()->ajax($position);
        }else{
            $data = Arr::only($params, ['name', 'is_channel', 'order_factor', 'parent_id']);
            $position = Position::create($data);
            return response()->ajax($position);
        }
    }

    public function subs(Request $request)
    {
        $params = $request->validate([
            'id' => 'numeric'
        ]);
        $id = $params['id'];
        $position = Position::find($id);
        if($position){
            $subs = $position->subs;
            return response()->ajax($subs);
        }
    }

    public function delete(Request $request)
    {
        // 检查是否被使用
    }

    // 所属推荐位的内容
    public function contents(Request $request)
    {
        $params = $request->validate([
            'id' => 'numeric'
        ]);
        $id = $params['id'];
        if($id){
            $position = Position::find($id);
            if($position->is_channel){
                $subIds = $position->subs->map(function($sub){return $sub->id;})->toArray();
                $contents = Position::whereIn('id', $subIds)->with('contents')->get()->map(function($position){
                    $position->contents->map(function ($content)use($position){
                        $content->position = ['id' => $position->id, 'name' => $position->name];
                    });
                    return $position->contents;
                });
                $contents = Arr::flatten($contents);
                $contents = Arr::sort($contents, function($content){
                    return $content->pivot->order_factor;
                });
                $contents = array_values($contents);
                return response()->ajax($contents);
            }else{
                $contents = Position::where('id', $id)->with('contents')->get()->map(function($item){
                    $item->contents->map(function ($content)use($item){
                        $content->position = ['id' => $item->id, 'name' => $item->name];
                    });
                    return $item->contents;
                });
                $contents = Arr::flatten($contents);
                $contents = Arr::sort($contents, function($content){
                    return $content->pivot->order_factor;
                });
                $contents = array_values($contents);
                return response()->ajax($contents);
            }
        }
    }
}
