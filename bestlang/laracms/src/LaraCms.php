<?php
namespace BestLang\LaraCms;

use BestLang\LaraCms\Models\Cms\Channel;
use BestLang\LaraCms\Models\Cms\Content;
use BestLang\LaraCms\Models\Cms\Position;
use BestLang\LaraCms\Models\Cms\Ad;
use BestLang\LaraCms\Models\Cms\AdPosition;
use BestLang\LaraCms\Models\Cms\Tag;
use Arr;

class LaraCms
{
    public function hotTags()
    {
        return Tag::withCount('contents')->orderBy('contents_count', 'desc')->limit(20)->get();
    }
    public function dateFormat($str)
    {
        return date('Y年m月d日 H:i', strtotime($str));
    }
    //Breadcrumbs
    public function breadcrumbs(Channel $channel)
    {
        $ancestors = $channel->ancestors()->get();
        $ancestors->push($channel);
        $ancestors->map(function($c){
            $c->url = route('channel', $c->id);
        });
        $ancestors->shift();
        $home = new Channel();
        $home->name = '首页';
        $home->url = '/';
        $ancestors->prepend($home);
        return $ancestors;
    }

    public function positionAds($positionName, $count=5)
    {
        $position = AdPosition::where('name', $positionName)->first();
        return $position->ads()->where('enabled', 1)->where('start_time', '<=', now())->where('end_time', '>=', now())->limit($count)->get();
    }

    public function channelContents($channelId, $count=5)
    {
        $contents = Content::where('channel_id', $channelId)->with(['metas', 'contents'])->limit($count)->get();
        return $contents;
    }

    public function latest($channelName='', $count=5)
    {
        $contents = Content::when($channelName, function($q) use ($channelName) {
            return $q->whereHas('fans',function($query) use ($channelName) {
                $query->where('channel.name','=',$channelName);
            });
        })->with(['metas', 'contents'])->limit($count)->get();
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
        return $contents;
    }

    public function channelPosition($name, $count=5){
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