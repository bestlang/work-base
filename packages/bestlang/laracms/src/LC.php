<?php
namespace Bestlang\Laracms;

use Bestlang\Laracms\Models\Cms\Content;
use Bestlang\Laracms\Models\Cms\Position;
use Arr;

class LC
{
    public function cc($channelId, $count=5)
    {
        return $this->categoryContents($channelId, $count);
    }
    public function categoryContents($channelId, $count=5)
    {
        $contents = Content::where('channel_id', $channelId)->with(['metas', 'contents'])->limit($count)->get();
        $contents->map(function($content){
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = $meta->value;
            }
            $content->ext = $ext;
        });
        return $contents;
    }
    public function latest($channelName='', $count=5)
    {
        $contents = Content::when($channelName, function($q) use ($channelName) {
            return $q->whereHas('fans',function($query) use ($channelName) {
                $query->where('channel.name','=',$channelName);
            });
        })->with(['metas', 'contents'])->limit($count)->get();
        $contents->map(function($content){
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = $meta->value;
            }
            $content->ext = $ext;
        });
        return $contents;
    }
    public function content($content, $field){
        $contents = $content->contents;
        foreach ($contents as $content){
            if($content->field == $field){
                return $content->value;
            }
        }
        return false;
    }
    public function position($name, $count=5){
        $position = Position::where('name', $name)->first();
        if(!$position){
            return [];
        }
        $contents = Position::where('name', $name)->first()->contents()->with(['metas', 'contents'])->limit($count)->get();
        $contents->map(function($content){
            $ext = [];
            foreach ($content->metas as $meta){
                $ext[$meta->field] = $meta->value;
            }
            $content->ext = $ext;
        });
        return $contents;
    }
    public function channel_position($name, $count=5){
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