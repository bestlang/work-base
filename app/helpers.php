<?php
use App\Models\Cms\Content;
use App\Models\Cms\Position;

// 推荐位函数
if(!function_exists('position')){
    function position($name){
        $contents = Position::where('name', $name)->first()->contents;
        $contents->map(function($content){
            foreach ($content->metas as $meta){
                $content->{$meta->field} = $meta->value;
            }
            unset($content->metas);
        });
        return $contents;
    }
}

if(!function_exists('channel_position')){
    function channel_position($name){
        $position = Position::where('name', $name)->where('is_channel', 1)->first();
        $channels = $position->channels;
        $subIds = $position->subs->map(function($sub){
            return $sub->id;
        });
        //取得所有子推荐位所有文章
        $positionContents = Position::whereIn('id', $subIds)->with('contents')->get()->map(function($position){
            return $position->contents;
        });
        $groupContents = [];
        $positionContents = Arr::flatten($positionContents);
        foreach ($positionContents as $content){
            foreach ($content->metas as $meta){
                $content->{$meta->field} = $meta->value;
            }
            $groupContents[$content->channel_id][] = $content;
        }
        //return $groupContents;//array_values($groupContents);
        $channels->map(function($channel)use($groupContents){
            if(Arr::get($groupContents, $channel->id)){
                $channelPositionContents = $groupContents[$channel->id];
                $channel->contents = Arr::sort($channelPositionContents, function($content){
                    return $content->pivot->order_factor;
                });
            }else{
                $channel->contents = [];
            }
        });
        return $channels;
    }
}