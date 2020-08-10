<?php
namespace Bestlang\Laracms;

use Bestlang\Laracms\Models\Cms\Channel;
use Bestlang\Laracms\Models\Cms\Content;
use Bestlang\Laracms\Models\Cms\Position;
use Bestlang\Laracms\Models\Cms\Ad;
use Bestlang\Laracms\Models\Cms\AdPosition;
use Bestlang\Laracms\Models\Cms\Tag;
use Arr;

class LC
{
    public function hot_tags()
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
    //alias of positionAds
    public function pa($positionName, $count=5)
    {
        return $this->positionAds($positionName, $count);
    }
    public function positionAds($positionName, $count=5)
    {
        $position = AdPosition::where('name', $positionName)->first();
        return $position->ads()->where('enabled', 1)->where('start_time', '<=', now())->where('end_time', '>=', now())->limit($count)->get();
    }

    //alias of categoryContents
    public function cc($channelId, $count=5)
    {
        return $this->categoryContents($channelId, $count);
    }
    public function categoryContents($channelId, $count=5)
    {
        $contents = Content::where('channel_id', $channelId)->with(['metas', 'contents'])->limit($count)->get();
        $contents->map(function($content){
            $content->ext = $content->getExt();
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
            $content->ext = $content->getExt();
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
            $content->ext = $content->getExt();
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
            $content->ext = $content->getExt();
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