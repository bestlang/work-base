<?php
namespace Bestlang\Laracms;

use Bestlang\Laracms\Models\Cms\Position;
use Arr;

class LC
{
//    public function meta($content, $field){
//        $metas = $content->metas;
//        foreach ($metas as $meta){
//            if($meta->field == $field){
//                return $meta->value;
//            }
//        }
//        return false;
//    }

    public function content($content, $field){
        $contents = $content->contents;
        foreach ($contents as $content){
            if($content->field == $field){
                return $content->value;
            }
        }
        return false;
    }
    public function position($name){
        $position = Position::where('name', $name)->first();
        if(!$position){
            return [];
        }
        $contents = Position::where('name', $name)->first()->contents()->with(['metas', 'contents'])->get();
        $contents->map(function($content){
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = $meta->value;
            }
            $content->ext = $ext;
        });
        return $contents;
    }
    public function channel_position($name){
        $position = Position::where('name', $name)->where('is_channel', 1)->first();
        if(!$position){
            return [];
        }
        $channels = $position->channels;
        $subIds = $position->subs->map(function($sub){
            return $sub->id;
        });
        //取得所有子推荐位所有文章
        $positionContents = Position::whereIn('id', $subIds)->get()->map(function($position){
            return $position->contents()->with(['metas', 'contents'])->get();
        });
        $groupContents = [];
        $positionContents = Arr::flatten($positionContents);
        foreach ($positionContents as $content){
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = $meta->value;
            }
            $content->ext = $ext;
            $groupContents[$content->channel_id][] = $content;
        }

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
        $channels = $channels->filter(function($channel){
            return count($channel->contents) !== 0;
        });
        return $channels;
    }
}