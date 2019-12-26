<?php
namespace  App\Apis;

use GuzzleHttp\Client;

class PddBase
{
    public $params = [];
    public $client = null;

    public function __construct()
    {
        $this->resetParams();
        $this->client = new Client();
    }

    public function resetParams(){
        $this->params = [
            'client_id' => env('PDD_CLIENT_ID'),//POP分配给应用的client_id
            'data_type' => 'JSON'
        ];
    }

    public function genSign()
    {
        $this->params['timestamp'] = time();
        ksort($this->params);
        $midStr = env('PDD_CLIENT_SECRET');
        foreach ($this->params as $k => $v){
            $midStr .= $k.$v;
        }
        $midStr .= env('PDD_CLIENT_SECRET');
        $midStr = md5($midStr);
        return strtoupper($midStr);
    }

    public function get_redirect_url($url, $referer='', $timeout = 10) {
        $redirect_url = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);//不返回请求体内容
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);//允许请求的链接跳转
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: */*',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36',
            'Connection: Keep-Alive'));
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);//设置referer
        }
        $content = curl_exec($ch);
        if(!curl_errno($ch)) {
            $redirect_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);//获取最终请求的url地址
        }

        return $redirect_url;
    }
}