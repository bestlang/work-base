<?php

namespace App\Http\Controllers\Pdd;

use App\CollectGoods;
use App\Pdd\PddOrder;
use App\Models\User;
use Illuminate\Http\Request;
use App\Apis\Pdd;
use GuzzleHttp\Client;
use Pay;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Apis\Mp;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        echo '123';

//        echo "heated welcome->".Cache::get('access_token');
//        echo "\nheated welcome->".Cache::get('xzs_access_token');
//        echo "\nheated welcome_>".Cache::get('fwh_access_token');
        return view('welcome');
    }

    public function notify()
    {
        return env('PDD_BASE_URL');
    }
    public function testJwtToken(Request $request)
    {
        $user = User::find(1);
        return JWTAuth::fromUser($user);
    }
    /**
     * @param Request $request
     * @param int $prepay_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wePay(Request $request)
    {
        $redirect = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx49a724deab97c52b&redirect_uri=https://www.larashop.com/pay?code=061D1j112MjkXV062321277l112D1j1I&state=123&response_type=code&scope=snsapi_base&state=123#wechat_redirect";

        $appId = env('WECHAT_APP_ID');
        $appSecret = env('WECHAT_APP_SECRET');
        $code = $request->input('code', '');
        if($code){
            $client = new Client();
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appId}&secret={$appSecret}&code={$code}&grant_type=authorization_code";
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $openid = json_decode($content)->openid;

            $order = [
                'out_trade_no' => time(),
                'body' => 'subject-测试',
                'total_fee' => '1',
                'openid' => $openid,
            ];
            $result = Pay::wechat()->mp($order);
            $viewData = [
                'appId'=>$result->appId,
                'timeStamp'=>$result->timeStamp,
                'nonceStr'=>$result->nonceStr,
                'package'=>$result->package,
                'signType'=>$result->signType,
                'paySign'=>$result->paySign
            ];
        }
        return view('pay', $viewData);
    }
    //获取推广位列表
    public function goodsPidQuery()
    {
        $pdd = new Pdd();
        $result = $pdd->goodsPidQuery();
    }
    //获取拼多多系统时间
    public function timeGet()
    {
        $pdd = new Pdd();
        $result = $pdd->timeGet();
    }
    //多多进宝推广链接生成
    public function goodsPromotionUrlGenerate(Request $request)
    {
        $pdd = new Pdd();
        $goodsId = $request->input('goodsId', 0);
        $type = $request->input('type', 'A');
        if($type == 'B'){ // 零元购商品 判断是否是该零元购是否存在&&优惠券是否依然存在

        }
        $result = $pdd->goodsPromotionUrlGenerate($goodsId, $type);
        $exists = auth()->user()->collectGoods()->where('goods_id', $goodsId)->first();
        $result->collected = $exists ? 1 : 0;
        return response()->ajax($result);
    }
    //多多客获取爆款排行商品接口
    public function topGoodsListQuery(Request $request)
    {
        $sort_type = $request->input('sort_type', 1);
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 100);
        $pdd = new Pdd();
        $result = $pdd->topGoodsListQuery($sort_type, $offset, $limit);
        return response()->ajax($result);
    }
    //查询多多进宝主题列表
    public function themeListGet(Request $request)
    {
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 50);
        $pdd = new Pdd();
        $result = $pdd->themeListGet($page, $page_size);
        return response()->ajax($result);
    }
    //查询主题商品列表
    public function themeGoodsSearch(Request $request, $theme_id)
    {
        $pdd = new Pdd();
        $result = $pdd->themeGoodsSearch($theme_id);
        return response()->ajax($result);
    }
    //
    public function orderDetailGet($order_sn)
    {
        $pdd = new Pdd();
        $exists = PddOrder::where('order_sn', $order_sn)->first();
        $result = [];
        if($exists){
            $result = $pdd->orderDetailGet($order_sn);
        }
        return response()->ajax($result);
    }
    //多多客生成转盘抽免单
    public function lotteryUrlGen(Request $request)
    {
        $refresh = $request->input('refresh', false);
        if(!$request){
            return ['statusCode'=>'200', 'data'=>config('pdd.lotteryUrl')];
        }
        $pdd = new Pdd();
        $result = $pdd->lotteryUrlGen();
        return response()->ajax($result->lottery_url_response->url_list[0]->we_app_info->page_path);
    }
    //生成红包推广链接
    public function rpPromUrlGenerate(Request $request){
        $refresh = $request->input('refresh', false);
        if(!$request){
            return ['statusCode'=>'200', 'data'=>config('pdd.rpUrl')];
        }
        $pdd = new Pdd();
        $result = $pdd->rpPromUrlGenerate();
        return response()->ajax($result->rp_promotion_url_generate_response->url_list[0]->we_app_info->page_path);
    }
    //多多进宝商品查询(关键字)
    public function goodsSearch(Request $request)
    {
        $opt_id = $request->input('opt_id', '');
        $keyword = $request->input('keyword', '');
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 20);
        $pdd = new Pdd();
        $result = $pdd->goodsSearch($opt_id, $keyword, $page, $page_size);
        return response()->ajax($result);
    }
    //商品标准类目接口
    public function goodsCatsGet(Request $request)
    {
        $pdd = new Pdd();
        $parent_cat_id = $request->input('parent_cat_id', 0);
        $result = $pdd->goodsCatsGet($parent_cat_id);
        return response()->ajax($result);
    }

    //查询商品标签列表
    public function goodsOptGet(){
        $pdd = new Pdd();
        $result = $pdd->goodsOptGet();
        return response()->ajax($result);
    }
    //生成商城-频道推广链接
    public function cmsPromUrlGenerate(Request $request)
    {
        $channel_type = $request->input('channel_type', -1);
        $pdd = new Pdd();
        $result = $pdd->cmsPromUrlGenerate();
        return response()->ajax($result);
    }

    // 查询时间段内
    // 从数据库缓存中取而不是请求接口
    public function orderListRangeGet(Request $request)
    {
        $time = time();
        $start_time = '2019-07-25 00:00:00';
        $end_time = date("Y-m-d H:i:s", $time );

        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 20);

        $pddOrders = PddOrder::orderBy('id', 'desc')->limit($page_size)->offset(( $page - 1 ) * $page_size)->get();
        return response()->ajax($pddOrders);

    }

    public function test(Request $request)
    {
//        $pdd = new Pdd();
//        $imageUrl = 'https://t00img.yangkeduo.com/goods/images/2019-07-07/ade48f55-fd34-40a6-928a-3151b39086c8.jpg';
//        $goodsId = '22222';
//        $userId = '11111';
//        echo $pdd->downloadImage($goodsId, $userId, $imageUrl, $force=false);
    }
}
