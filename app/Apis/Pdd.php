<?php
namespace  App\Apis;

use App\Console\Commands\PddCats;
use App\Pdd\OptGoodsSearch;
use App\Pdd\ThemeListGet;
use App\Pdd\TopGoodsListQuery;
use App\Pdd\ThemeGoodsSearch;
use App\Pdd\GoodsPromotionUrlGenerate;
use App\Pdd\PddOrder;
use App\User;
use App\UserMoney;
use App\Pdd\Cat as PddCat;
use Arr;

class Pdd extends PddBase
{
    protected $p_id = '1910307_23579444';
    protected $time_range = 86400;

    /**
     * @param $goodsId
     * @param string $buyType
     * @return mixed
     * 多多进宝推广链接生成
     */
    public function goodsPromotionUrlGenerate($goodsId, $buyType='A')
    {
        $dbRow = GoodsPromotionUrlGenerate::where('goods_id', $goodsId)->first();
        if(!$dbRow){
            $dbRow = new GoodsPromotionUrlGenerate();
            $dbRow->aio = [];
            $dbRow->goods_id = $goodsId;
            $dbRow->save();
        }

        $this->params['type'] = 'pdd.ddk.goods.promotion.url.generate';
        $this->params['p_id'] = $this->p_id;
        $this->params['goods_id_list'] = "[{$goodsId}]";
        $this->params['generate_we_app'] = 'true';
        $this->params['custom_parameters'] = auth()->user()->id.$buyType;

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();

        $dbRow->aio = json_decode($content);
        $dbRow->save();

        return json_decode($content);
    }

    public function orderDetailGet($order_sn)
    {
        $this->params['type'] = 'pdd.ddk.order.detail.get';
        $this->params['order_sn'] = $order_sn;
        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }
    /**
     * 获取推广位列表
     */
    public function goodsPidQuery()
    {
        $this->params['type'] = 'pdd.ddk.goods.pid.query';

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }

    /**
     * 获取拼多多系统时间
     */
    public function timeGet()
    {
        $this->params['type'] = 'pdd.time.get';

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        print_r($content);
    }

    /**
     * @param int $sort_type
     * @param int $offset
     * @param int $limit
     * @return mixed
     * 多多客获取爆款排行商品接口
     */
    public function topGoodsListQuery($sort_type=1, $offset=0, $limit=400)
    {
        $this->time_range = 120; // 不缓存
        $dbRow = TopGoodsListQuery::where('offset', $offset)->where('limit', $limit)->first();
        if($dbRow){
            if(time()-strtotime($dbRow['updated_at'])<$this->time_range){
                return json_decode($dbRow['aio']);
            }
        }else{
            $dbRow = new TopGoodsListQuery();
            $dbRow->aio = [];
            $dbRow->offset = $offset;
            $dbRow->limit = $limit;
            $dbRow->save();
        }

        $this->params['type'] = 'pdd.ddk.top.goods.list.query';
        $this->params['p_id'] = $this->p_id;
        $this->params['sort_type'] = $sort_type;//1-实时热销榜；2-实时收益榜
        $this->params['offset'] = $offset;
        $this->params['limit'] = $limit;

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();

        $result = json_decode($content);
        foreach ($result->top_goods_list_get_response->list as $key => &$goods){
            $goods_id = $goods->goods_id;
            $goods_thumbnail_url = $goods->goods_thumbnail_url;
            $goods_name = $goods->goods_name;
            $coupon_discount = $goods->coupon_discount;
            $min_group_price = $goods->min_group_price;
            $min_normal_price = $goods->min_normal_price;
            $promotion_rate = $goods->promotion_rate;
            $sales_tip = $goods->sales_tip;
            $cat_id = array_pop($goods->cat_ids);
            $obj = new \stdClass();
            $obj->goods_id = $goods_id;
            $obj->goods_thumbnail_url = $goods_thumbnail_url;
            $obj->goods_name = $goods_name;
            $obj->coupon_discount = $coupon_discount;
            $obj->min_group_price = $min_group_price;
            $obj->goods_id = $goods_id;
            $obj->min_normal_price = $min_normal_price;
            $obj->promotion_rate = $promotion_rate;
            $obj->sales_tip = $sales_tip;
            $pddCat = PddCat::where('cat_id', $cat_id)->first();
            if($pddCat){
                $obj->cat_name = $pddCat->cat_name;
            }else{
                $obj->cat_name = '';
            }
            $result->top_goods_list_get_response->list[$key] = $obj;
        }
        $dbRow->aio = json_encode($result);
        $dbRow->offset = $offset;
        $dbRow->limit = $limit;
        $dbRow->save();
        return $result;
    }

    /**
     * @param int $page
     * @param int $page_size
     * @return mixed
     * 查询多多进宝主题列表
     */
    public function themeListGet($page=1, $page_size=50)
    {
        $this->time_range = 0; // 不缓存
        $dbRow = ThemeListGet::where('page', $page)->where('page_size', 50)->first();
        if($dbRow){
            if(time()-strtotime($dbRow['updated_at'])<$this->time_range){
                $cached = json_decode($dbRow['aio']);
                if(isset($cached->theme_list_get_response)){
                    return $cached;
                }
            }
        }else{
            $dbRow = new ThemeListGet();
            $dbRow->aio = '{}';
            $dbRow->page = $page;
            $dbRow->page_size = $page_size;
            $dbRow->save();
        }

        $this->params['type'] = 'pdd.ddk.theme.list.get';
        $this->params['page'] = $page;// range 1-10000
        $this->params['page_size'] = $page_size;

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        $count_flag = 0;
        while($count_flag++<5 && isset(json_decode($content)->error_response)){
            $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
            $content = $response->getBody()->getContents();
        }

        $dbRow->aio = $content;
        $dbRow->page = $page;
        $dbRow->page_size = $page_size;
        $dbRow->save();
        return json_decode($content);
    }

    /**
     * @param $theme_id
     * @return string
     * 多多进宝主题商品查询
     */
    public function themeGoodsSearch($theme_id)
    {
        $this->time_range = 0;
        $dbRow = ThemeGoodsSearch::where('theme_id', $theme_id)->first();
        if($dbRow){
            if(time()-strtotime($dbRow->updated_at)<$this->time_range){
                return $dbRow->aio;
            }
        }else{
            $dbRow = new ThemeGoodsSearch();
            $dbRow->aio = [];
            $dbRow->theme_id = $theme_id;
            $dbRow->save();
        }
        $this->params['type'] = 'pdd.ddk.theme.goods.search';
        $this->params['theme_id'] = $theme_id;

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();

        $result = json_decode($content);
        foreach ($result->theme_list_get_response->goods_list as $key => &$goods){
            $goods_id = $goods->goods_id;
            $goods_thumbnail_url = $goods->goods_thumbnail_url;
            $goods_name = $goods->goods_name;
            $coupon_discount = $goods->coupon_discount;
            $min_group_price = $goods->min_group_price;
            $min_normal_price = $goods->min_normal_price;
            $promotion_rate = $goods->promotion_rate;
            $sales_tip = $goods->sales_tip;
            $cat_id = array_pop($goods->cat_ids);
            $obj = new \stdClass();
            $obj->goods_id = $goods_id;
            $obj->goods_thumbnail_url = $goods_thumbnail_url;
            $obj->goods_name = $goods_name;
            $obj->coupon_discount = $coupon_discount;
            $obj->min_group_price = $min_group_price;
            $obj->goods_id = $goods_id;
            $obj->min_normal_price = $min_normal_price;
            $obj->promotion_rate = $promotion_rate;
            $obj->sales_tip = $sales_tip;
            $pddCat = PddCat::where('cat_id', $cat_id)->first();
            if($pddCat){
                $obj->cat_name = $pddCat->cat_name;
            }else{
                $obj->cat_name = '';
            }
            $result->theme_list_get_response->goods_list[$key] = $obj;
        }

        $dbRow->aio = json_encode($result);
        $dbRow->theme_id = $theme_id;
        $dbRow->save();
        return $result;
    }
    /**
     * 多多客生成转盘抽免单小程序跳转path
     */
    public function lotteryUrlGen()
    {
        $this->params['type'] = 'pdd.ddk.lottery.url.gen';
        $this->params['pid_list'] = "[\"{$this->p_id}\"]";
        $this->params['generate_we_app'] = 'true';

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }

    /**
     * 生成红包推广链接
     */
    public function rpPromUrlGenerate()
    {
        $this->params['type'] = 'pdd.ddk.rp.prom.url.generate';
        $this->params['p_id_list'] = "[\"{$this->p_id}\"]";
        $this->params['generate_weapp_webview'] = 'false';
        $this->params['generate_we_app'] = 'true';

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }
    //多多进宝商品查询(关键字)
    public function goodsSearch($opt_id='', $keyword='', $page=1, $page_size=20)
    {
        $this->params['type'] = 'pdd.ddk.goods.search';
        $dbRow = null;
        $opt_id = intval($opt_id);
        if($opt_id>0){
            $dbRow = OptGoodsSearch::where('opt_id', $opt_id)->where('page', $page)->where('page_size', $page_size)->first();
            if($dbRow){
                if(time()-strtotime($dbRow['updated_at'])<$this->time_range){
                    return json_decode($dbRow['aio'])->goods_search_response->goods_list;
                }else{
                    //@todo
                    //整表更新
                }
            }
        }
        if(1||$opt_id && $opt_id != 99999){
            $this->params['opt_id'] = $opt_id;
        }
        if($keyword){
            $this->params['keyword'] = $keyword;
            if(preg_match("/(https:\/\/p\.pinduoduo\.com\/[^\s]+)/", $keyword, $matches)){
                $url = $this->get_redirect_url($matches[1]);
                if(preg_match("/goods_id=(\d+)/", $url, $mat)){
                    $this->params['keyword'] = $mat[1];
                }
            }else if(preg_match("/goods_id=([\d]+)/", $keyword, $mat)){
                $this->params['keyword'] = $mat[1];
            }else if(mb_strlen($keyword) > 50){
                if(preg_match("/([^\s]+)/", $keyword, $mat)){
                    $this->params['keyword'] = $mat[1];
                }else {
                    $this->params['keyword'] = mb_substr($keyword, 0, 20, 'UFT-8');
                }
            }


        }
        $this->params['page'] = $page;
        $this->params['page_size'] = $page_size;
        $this->params['sort_type'] = 6;
        /*sort_type排序方式:
        0-综合排序;
        1-按佣金比率升序;
        2-按佣金比例降序;
        3-按价格升序;
        4-按价格降序;
        5-按销量升序;
        6-按销量降序;
        7-优惠券金额排序升序;
        8-优惠券金额排序降序;
        9-券后价升序排序;
        10-券后价降序排序;
        11-按照加入多多进宝时间升序;
        12-按照加入多多进宝时间降序;
        13-按佣金金额升序排序;
        14-按佣金金额降序排序;
        15-店铺描述评分升序;
        16-店铺描述评分降序;
        17-店铺物流评分升序;
        18-店铺物流评分降序;
        19-店铺服务评分升序;
        20-店铺服务评分降序;
        27-描述评分击败同类店铺百分比升序，
        28-描述评分击败同类店铺百分比降序，
        29-物流评分击败同类店铺百分比升序，
        30-物流评分击败同类店铺百分比降序，
        31-服务评分击败同类店铺百分比升序，
        32-服务评分击败同类店铺百分比降序
        */
        if(isset($this->params['opt_id'])&&$this->params['opt_id']){
            $this->params['with_coupon'] = 'true';//只返回带优惠券的商品
        }else if(Arr::get($this->params, 'keyword')&&preg_match("/^(\d+)$/", $this->params['keyword'])){
            $this->params['with_coupon'] = 'false';
        }else{
            $this->params['with_coupon'] = 'true';
        }
        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();

        $result = json_decode($content);
        foreach ($result->goods_search_response->goods_list as $key => &$goods){
            $goods_id = $goods->goods_id;
            $goods_thumbnail_url = $goods->goods_thumbnail_url;
            $goods_name = $goods->goods_name;
            $coupon_discount = $goods->coupon_discount;
            $min_group_price = $goods->min_group_price;
            $min_normal_price = $goods->min_normal_price;
            $promotion_rate = $goods->promotion_rate;
            $sales_tip = $goods->sales_tip;
            $cat_id = array_pop($goods->cat_ids);
            $obj = new \stdClass();
            $obj->goods_id = $goods_id;
            $obj->goods_thumbnail_url = $goods_thumbnail_url;
            $obj->goods_name = $goods_name;
            $obj->coupon_discount = $coupon_discount;
            $obj->min_group_price = $min_group_price;
            $obj->goods_id = $goods_id;
            $obj->min_normal_price = $min_normal_price;
            $obj->promotion_rate = $promotion_rate;
            $obj->sales_tip = $sales_tip;
            $pddCat = PddCat::where('cat_id', $cat_id)->first();
            if($pddCat){
                $obj->cat_name = $pddCat->cat_name;
            }else{
                $obj->cat_name = '';
            }

            $result->goods_search_response->goods_list[$key] = $obj;
        }

        if($opt_id){
            if(!$dbRow){
                $dbRow = new OptGoodsSearch();
            }
            $dbRow->aio = json_encode($result);
            $dbRow->opt_id = $opt_id;
            $dbRow->page = $page;
            $dbRow->page_size = $page_size;
            $dbRow->save();
        }
        return $result->goods_search_response->goods_list;
    }

    //商品标准类目接口
    public function goodsCatsGet($parent_cat_id=0)
    {
        $this->resetParams();
        $this->params['type'] = 'pdd.goods.cats.get';
        $this->params['parent_cat_id'] = $parent_cat_id;

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        $de = json_decode($content);
        if(isset($de->goods_cats_get_response)){
            if(isset($de->goods_cats_get_response->goods_cats_list)){
                return json_decode($content)->goods_cats_get_response->goods_cats_list;
            }
        }
        return [];
    }

    //查询商品标签列表
    public function goodsOptGet()
    {
        $this->params['type'] = 'pdd.goods.opt.get';
        $this->params['parent_opt_id'] = '0';

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }
    //生成商城-频道推广链接
    //$channel_type: 0, "1.9包邮"；1, "今日爆款"； 2, "品牌清仓"； 4,"PC端专属商城"
    public function cmsPromUrlGenerate($channel_type=-1)
    {
        $this->params['type'] = 'pdd.ddk.cms.prom.url.generate';
        $this->params['we_app_web_view_short_url'] = 'false';
        $this->params['we_app_web_view_url'] = 'false';
        if($channel_type>=0){
            $this->params['channel_type'] = "{$channel_type}";
        }
        $this->params['p_id_list'] = "[\"{$this->p_id}\"]";

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        return json_decode($content);
    }
    // 用时间段查询推广订单接口并插入数据库
    // net request
    // 从命令行被调用
    public function orderListRangeGet()
    {
        $this->params['type'] = 'pdd.ddk.order.list.range.get';
        $last_order_id = null;
        $latestOne = PddOrder::orderBy('id', 'desc')->first();
        if($latestOne&&$latestOne->last_order_id){
            $last_order_id = $latestOne->last_order_id;
        }
        $start_time = '2019-07-20 00:00:00';
        $this->params['start_time'] = $start_time;
        $time = time();
        $end_time = date("Y-m-d H:i:s", $time );
        $this->params['end_time'] = $end_time;

        $order_count = PddOrder::count();
        $page_size = 300;

        if($order_count>=$page_size){
            if($last_order_id){
                $this->params['last_order_id'] = $last_order_id;
            }
        }
        $this->params['page_size'] = $page_size;

        $this->params['sign'] = $this->genSign();
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        $result = json_decode($content);

        if(isset($result->order_list_get_response)){
            $order_list_get_response = $result->order_list_get_response;
            if(isset($order_list_get_response->last_order_id)){
                $last_order_id = $order_list_get_response->last_order_id;
                $order_list = $order_list_get_response->order_list;
                // info('ORDER_LIST:');
                // info($order_list);
                foreach ($order_list as $key => $order){
                    $arr = collect($order)->toArray();
                    $known_keys = [
                        'goods_name',
                        'goods_price',
                        'goods_quantity',
                        'goods_id',
                        'promotion_rate',
                        'goods_thumbnail_url',
                        'custom_parameters',
                        'promotion_amount',
                        'order_status',
                        'order_pay_time',
                        'order_create_time',
                        'order_group_success_time',
                        'order_amount',
                        'order_status_desc',
                        'order_modify_at',
                        'order_sn',
                        'p_id',
                        'cpa_new'
                    ];
                    $ready_to_save = [];
                    foreach ($known_keys as $nk){
                        // 拼团没成功 此参数order_group_success_time缺失
                        $ready_to_save[$nk] = Arr::get($arr, $nk, null);
                    }
                    try{
                        $po = PddOrder::where('order_sn', $order->order_sn)->firstOrfail();
                        $po->update($ready_to_save);
                    }catch (\Exception $e){
                        $po = PddOrder::create($ready_to_save);
                        $this->orderProfitDispatch($po);
                    }
                    if($key == 0){
                        $po->last_order_id = $last_order_id;
                    }
                    $po->save();
                }
            }
        }
    }
    // 查询订单详情并分发收益到各个用户
    // 从命令行被调用
    public function orderProfitDispatch($order)
    {
        /**
         * 订单状态描述（ -1 未支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）;10-已处罚）
         */
        $this->resetParams();

        defined('F_THRESHOLD') || define('F_THRESHOLD' , env('F_THRESHOLD', 200));

        $order_sn = $order->order_sn;
        $order_pay_time = date("Y-m-d H:i:s", $order->order_pay_time);
        echo $order_sn,"\n";
        $this->params['type'] = 'pdd.ddk.order.detail.get';
        $this->params['order_sn'] = $order_sn;

        $this->params['sign'] = $this->genSign();
//        print_r($this->params);
        $response = $this->client->request('POST', env('PDD_BASE_URL'), [ 'form_params' => $this->params ]);
        $content = $response->getBody()->getContents();
        $result = json_decode($content);
//        print_r($result);
        if(isset($result->error_response)){
            $result->order_detail_responce = $result->error_response;
            return $result;
        }
        if(isset($result->order_detail_response)){
            $res = $result->order_detail_response;
            if(strpos($res->cps_sign, $this->p_id)>0){//判断是否是本公司推广的产品
                // 更新订单表
                $order_status = $res->order_status;
                $order_status_desc = $res->order_status_desc;
                if($order_status != $order->order_status){
                    $order->order_status = $order_status;
                    $order->order_status_desc = $order_status_desc;
                    $order->save();
                }
                // 更新(插入)收益表
                $custom_parameters = $order->custom_parameters;
                $stop_once = false;
                $buyType= 'A';
                if(strpos($custom_parameters, 'A') !== false){
                    $contributer_id = str_replace('A', '', $custom_parameters);
                }else if(strpos($custom_parameters, 'B') !== false){
                    $buyType = 'B';
                    $contributer_id = str_replace('B', '', $custom_parameters);
                    $stop_once = true;
                }else if(strpos($custom_parameters, 'C') !== false){
                    $buyType = 'C';
                    $contributer_id = str_replace('C', '', $custom_parameters);
                    $stop_once = true;
                }
                // @todo 判断是否新用户 目前仅仅在前端跳转的地方拦截
                if(false){
                    $stop_once = false;
                }

                $user_money_self = null; // 自身返利收益
                $user_money_parent = null; // 上级返利收益
                $user_money_grand_parent = null; // 上上级返利收益
                // 1st 自身收益
                try{
                    $user_money_self = UserMoney::where('user_id', $contributer_id)->where('order_sn', $order_sn)->firstOrFail();
                    $user_money_self->order_status = $order->order_status;
                }catch (\Exception $e){
                    $amount = ceil(($order->promotion_amount/100) * config('f.F_A') * 10)/10;
                    if($stop_once){
                        // 大于"免费拿"阈值要阻隔掉
                        if($buyType == 'B' && $order->order_amount > F_THRESHOLD){
                            $order->order_amount = F_THRESHOLD;
                        }
                        $amount = sprintf('%.2f', ($order->order_amount/100));
                    }
                    $user_money_self = UserMoney::create([
                        'user_id' => $contributer_id,
                        'type' => '1',// 1 购物返利
                        'order_status' => $order->order_status,
                        'amount' => $amount,
                        'contributer_id' => $contributer_id,
                        'order_sn' => $order_sn,
                        'plantform' => '1', // 1. 拼多多
                        'level' => '1', // 直接购物返利
                        'order_pay_time' => $order_pay_time
                        ]);
                }
                $user_money_self->save();

                if($stop_once){
                    return true;
                }

                // 2nd 上级收益
                $contributer = User::find($contributer_id);
                if($contributer){
                    $parent_user_id = $contributer->parent_id;
                    if($parent_user_id){
                        $parent_user = User::find($parent_user_id);
                        if($parent_user){
                            try{
                                $user_money_parent = UserMoney::where('user_id', $parent_user_id)->where('order_sn', $order_sn)->firstOrFail();
                                $user_money_parent->order_status = $order->order_status;
                            }catch (\Exception $e){
                                $amount = ($order->promotion_amount/100) * config('f.F_B');
                                $user_money_parent = UserMoney::create([
                                    'user_id' => $parent_user_id,
                                    'type' => '1',// 1 购物返利
                                    'order_status' => $order->order_status,
                                    'amount' => $amount,
                                    'contributer_id' => $contributer_id,
                                    'order_sn' => $order_sn,
                                    'plantform' => '1', // 1. 拼多多
                                    'level' => '2', // 下级购物返利
                                    'order_pay_time' => $order_pay_time
                                ]);
                            }
                            $user_money_parent->save();
                            // 有上级才可能有上上级
                            // 3rd 上上级收益
                            $grand_parent_user_id = $parent_user->parent_id;
                            if($grand_parent_user_id){
                                $grand_parent_user = User::find($grand_parent_user_id);
                                if($grand_parent_user){
                                    try{
                                        $user_money_grand_parent = UserMoney::where('user_id', $grand_parent_user_id)->where('order_sn', $order_sn)->firstOrFail();
                                        $user_money_grand_parent->order_status = $order->order_status;
                                        $user_money_grand_parent->save();
                                    }catch (\Exception $e){
                                        $amount = ($order->promotion_amount/100) * config('f.F_C');
                                        if($amount){
                                            $user_money_grand_parent = UserMoney::create([
                                                'user_id' => $grand_parent_user_id,
                                                'type' => '1',// 1 购物返利
                                                'order_status' => $order->order_status,
                                                'amount' => $amount,
                                                'contributer_id' => $contributer_id,
                                                'order_sn' => $order_sn,
                                                'plantform' => '1', // 1. 拼多多
                                                'level' => '3', // 下下级购物返利
                                                'order_pay_time' => $order_pay_time
                                            ]);
                                        }
                                    }

                                }
                            }
                        }
                    }
                }

            }
        }
    }

    public function downloadImage($imageUrl, $nameFactor,  $force=false)
    {
        $baseDir = storage_path("app/public/goods-images/");
        if(!file_exists($baseDir)){
            mkdir($baseDir, 0777, true);
        }
        $fileName = 'pdd-'.$nameFactor.'.png';
        $file = $baseDir.$fileName;
        if(!file_exists($file) || $force){
            $src = file_get_contents($imageUrl);
            file_put_contents($file, $src);
        }
        return "/storage/goods-images/".$fileName;
    }

}