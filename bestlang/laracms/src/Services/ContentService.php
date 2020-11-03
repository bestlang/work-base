<?php
namespace BestLang\Laracms\Services;

use BestLang\Laracms\Models\Cms\Content;
use BestLang\Laracms\Models\Cms\Channel;
use BestLang\Laracms\Models\Cms\ContentMeta;
use BestLang\Laracms\Models\Cms\ContentContent;
use Arr;

class ContentService
{
    public static function contents($channelId, $page=1, $pageSize=10, $keyword='')
    {
        $channelId = intval($channelId);
        $page = intval($page);
        $pageSize = intval($pageSize);

        $query = Content::query();
        if($keyword){
            $query = $query
                ->where('title', 'like', "%{$keyword}%")
                ->orWhere('keywords', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        }
        $total = $query->count();

        if(!$channelId){
            $contents = $query->with('channel')
                ->orderBy('id', 'desc')
                ->limit($pageSize)
                ->offset(($page-1)*$pageSize)
                ->get();
//            return response()->ajax(compact(['contents', 'total']));
        }else{
            $channelIdArr = [];
            $childrenIdArr = Channel::find($channelId)
                ->getDescendantsAndSelf()
                ->map(function($item){return $item->id;})
                ->toArray();
            if(count($childrenIdArr)){
                array_push($channelIdArr, ...$childrenIdArr);
            }
            $query->whereIn('channel_id', $channelIdArr);
            $total = $query->count();
            $contents = $query
                ->with(['channel'])
                ->orderByRaw("case when `channel_id`=$channelId then 1 end desc")
                ->orderBy('id', 'desc')
                ->limit($pageSize)
                ->offset(($page-1)*$pageSize)
                ->get();
        }
        $contents->map(function($content){
            $content->link = route('content', $content->id);
            if(!$content->channel->content_template){
                $content->link = '';
            }
        });
        return ['contents' => $contents, 'total' => $total];
    }

    public static function content($contentId)
    {
        $content = Content::with(['contents', 'metas', 'tags'])->find($contentId);

        $filedTypeMap = [];
        $content->model->fields->filter(function($item){
            return !$item->is_channel;
        })->each(function($modelField)use(&$filedTypeMap, &$content){
            if($modelField->is_custom){
                if($modelField->type == 'content'){
                    //确保$content->contents里面包含此值
                    $has = $content->contents->search(function($cc)use($modelField){
                        return $cc->field == $modelField->field;
                    });
                    if($has === false){
                        $cc = new ContentContent();
                        //$cc->content_id = $content->id;
                        $cc->field = $modelField->field;
                        $cc->value = '';
                        $content->contents->push($cc);
                    }
                }else{
                    //确保$content->metas里面此值存在,至少为空
                    $has = $content->metas->search(function($cc)use($modelField){
                        return $cc->field == $modelField->field;
                    });
                    if($has === false){
                        $cm = new ContentMeta();
                        //$cm->content_id = $content->id;
                        $cm->field = $modelField->field;
                        $cm->value = '';
                        $content->metas->push($cm);
                    }
                }
                $filedTypeMap[$modelField->field] = $modelField->type;
            }
        });
        $content->positions = $content->positions()->get()->map(function($position){
            return $position->id;
        });
        $content->metas->map(function($meta)use($filedTypeMap){
            $type = Arr::get($filedTypeMap, $meta->field, null);
            //checkbox特殊处理,数据库中1,2,3取出之后封装成[1,2,3]
            if($type == 'checkbox' && $meta->value){
                $meta->value = array_values(array_filter(explode(',', $meta->value)));
            }
            //多图特殊处理,以json根式存储
            if($type == 'multiple-image' || $type == 'attachment'){
                $meta->value = json_decode($meta->value);
            }
        });

        return $content;
    }
}