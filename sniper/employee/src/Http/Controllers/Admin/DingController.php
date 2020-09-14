<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DingController
{
    public function _getAccessToken()
    {
        $appKey  = config('ding.AppKey');
        $appSecret = config('ding.AppSecret');
        $client = new Client();
        $url = "https://oapi.dingtalk.com/gettoken?appkey={$appKey}&appsecret={$appSecret}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        return json_decode($content)->access_token;
    }

    public function departments(Request $request)
    {
        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/department/list?access_token={$access_token}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $departments = json_decode($content)->department;
        $rootKey = 0;
        $departmentIds = [];
        foreach ($departments as $key => &$department){
            $departmentIds[] = $department->id;
            if(!isset($department->children)){
                $department->children = [];
            }
            if(isset($department->parentid)){
                for($i=0;$i<count($departments); $i++){
                    if($departments[$i]->id == $department->parentid){
                        $departments[$i]->children[] = $department;
                    }
                }
            }else{
                $rootKey = $key;
            }
        }
        //return response()->ajax( $departments[$rootKey] );
        return response()->ajax( ['departments' => $departments[$rootKey], 'departmentIds' =>$departmentIds] );
    }

    public function _getDepartmentUsers($departmentId)
    {
        $users = [];
        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/user/simplelist?access_token={$access_token}&department_id={$departmentId}";
        $response = $client->request('GET', $url, ['offset' => 0, 'size' => 100]);
        $content = $response->getBody()->getContents();
        $users[] = json_decode($content)->userlist;

    }
}