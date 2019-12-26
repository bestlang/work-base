<?php

namespace App\Http\Controllers;

use App\Apis\Pdd;
use App\Pdd\GoodsPromotionUrlGenerate;
use Illuminate\Http\Request;
use App\Apis\Mp;

class MaterialController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $imageList = [
            '/images/adimg/img3.png',
        ];
        /**
         * '等超市降价很难',
        '买优惠东西确很简单',
        '只要微信搜索小程序',
        '一年省出上千一点都不难!'
         */
        $words = [
            '限时免费领礼物啦',
            '识别小程序代码打开小程序',
            '就可以免费领一件商品',
            '赶快告诉好友吧!'
        ];
        $userId = $user->id;
        $mp = new Mp;
        $codeImgUrl = $mp->genMpImage($userId);
        $nickName = "刷福利";
        $avatarUrl = "https://wx.qlogo.cn/mmopen/vi_32/3GaBBBm1G1OXfkoTPCme73erDTv30Pgbiar5WBxUHgoUgx6jphD5c9icg0XIwXe6kVblJBwpwVwQ9y7lZxxHVfQQ/132";
        if(isset($user->mp['userInfo'])){
            $nickName = $user->mp['userInfo']['nickName'];
            $avatarUrl = $user->mp['userInfo']['avatarUrl'];
        }
        return response()->json(
            [
                'statusCode'=>'200',
                'data' => [
                    'imageList'=>$imageList,
                    'codeImgUrl'=>$codeImgUrl,
                    'nickName'=>$nickName,
                    'avatarUrl'=>$avatarUrl,
                    'words'=>$words
                ]
            ],
            200);
    }

    public function goods(Request $request)
    {
        $srcGoodsImageUrl = $request->input('srcGoodsImageUrl');
        $goodsId = $request->input('goodsId');
        $user = auth()->user();
        $mp = new Mp;
        $codeImgUrl = $mp->genGoodsMpImage($user->id, $goodsId) . '?t=' . time();
        $nickName = "刷福利";
        $avatarUrl = "https://wx.qlogo.cn/mmopen/vi_32/3GaBBBm1G1OXfkoTPCme73erDTv30Pgbiar5WBxUHgoUgx6jphD5c9icg0XIwXe6kVblJBwpwVwQ9y7lZxxHVfQQ/132";
        if(isset($user->mp['userInfo'])){
            $nickName = $user->mp['userInfo']['nickName'];
            $avatarUrl = $user->mp['userInfo']['avatarUrl'];
        }
        $pdd = new Pdd();
        $goodsImageUrl = $pdd->downloadImage($srcGoodsImageUrl, $goodsId.'-0', $force=false);
        return response()->json(
            [
                'statusCode'=>'200',
                'data' => [
                    'codeImgUrl'=>$codeImgUrl,
                    'nickName'=>$nickName,
                    'avatarUrl'=>$avatarUrl,
                    'goodsImageUrl'=>$goodsImageUrl
                ]
            ],
            200);
    }
    // 详情图片异步做
    public function goodsImages(Request $request)
    {
        $goodsId = $request->input('goodsId');
        $gg = GoodsPromotionUrlGenerate::where('goods_id', $goodsId)->first();
        $goodsImageUrls = [];
        if($gg){
            $urls = $gg->aio['goods_promotion_url_generate_response']['goods_promotion_url_list']['0']['goods_detail']['goods_gallery_urls'];

            $pdd = new Pdd();
            foreach ($urls as $index => $url){
                $goodsImageUrls[] = $pdd->downloadImage($url, $goodsId.'-'.$index, $force=false);
            }
        }
        return response()->json(
            [
                'statusCode'=>'200',
                'data' => [
                    'goods_gallery_urls' => $goodsImageUrls
                ]
            ],
            200);
    }
}
