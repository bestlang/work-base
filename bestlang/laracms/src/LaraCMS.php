<?php
namespace BestLang\LaraCMS;

use BestLang\LaraCMS\Models\Cms\Channel;
use BestLang\LaraCMS\Models\Cms\Content;
use BestLang\LaraCMS\Models\Cms\Position;
use BestLang\LaraCMS\Models\Cms\Ad;
use BestLang\LaraCMS\Models\Cms\AdPosition;
use BestLang\LaraCMS\Models\Cms\Tag;
use Arr;
use HashConfig;

class LaraCMS
{
    public function moduleName()
    {
        return 'LaraCMS';
    }

    public function homePage()
    {
        return render('index.index');
    }

    public function authPrefix()
    {
        $theme = HashConfig::get('site', 'theme');
        return "LaraCMS::themes.{$theme}.";
    }

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
        $home->url = route('cms');
        $ancestors->prepend($home);
        return $ancestors;
    }

    public function positionAds($positionName, $count=5)
    {
        $position = AdPosition::where('name', $positionName)->firstOrFail();
        return $position->ads()->where('enabled', 1)->where('start_time', '<=', now())->where('end_time', '>=', now())->limit($count)->get();
    }

    public function channelContents($channelId, $count=5)
    {
        $contents = Content::where('channel_id', $channelId)->with(['metas', 'contents'])->orderBy('id', 'asc')->limit($count)->get();
        return $contents;
    }

    public function latest($channelName='', $count=5)
    {
        $contents = Content::when($channelName, function($q) use ($channelName) {
            $q->where('channel.name','=',$channelName);
        })->whereHas('channel', function($query){ $query->where('content_template', '!=', '');})->with(['metas', 'contents'])->limit($count)->get();
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
        $contents = $position->contents()->with(['metas', 'contents'])->limit($count)->get();
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