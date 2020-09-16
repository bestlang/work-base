<?php
namespace Sniper\Employee\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Sniper\Employee\Models\DingTalk\Department as DingDepartment;

class DingTalk
{
    public function _getAccessToken()
    {
        $appKey  = config('ding.AppKey');
        $appSecret = config('ding.AppSecret');
        $client = new Client();
        $url = "https://oapi.dingtalk.com/gettoken?appkey={$appKey}&appsecret={$appSecret}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $access_token = null;
        try{
            $access_token = json_decode($content)->access_token;
        }catch (\Exception $e){
            echo "_getAccessToken:", "\n", $content, "\n";
        }
        return $access_token;
    }

    public function departments()
    {
        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/department/list?access_token={$access_token}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $departments = json_decode($content)->department;
        $rawDepartments = $departments;
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
        return ['departments' => $departments[$rootKey], 'departmentIds' => $departmentIds, 'rawDepartments' => $rawDepartments];
    }

    public function _getDepartmentUsers($departmentId)
    {
        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/user/simplelist?access_token={$access_token}&department_id={$departmentId}";
        $response = $client->request('GET', $url);//, [ 'query' => ['offset' => 0, 'size' => 100]]如果使用query, $url中就不能带参数
        $content = $response->getBody()->getContents();
        $users = [];
        try {
            $users = json_decode($content)->userlist;
        }catch (\Exception $e){
            echo "_getDepartmentUsers:", "\n", $content, "\n";
        }
        return $users;
    }

    public function _getUser($userid)
    {
        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/user/get?access_token={$access_token}&userid={$userid}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        echo $content, "\n";
        $user =  json_encode($content);
        return $user;
    }

    public function _getUserAttendance($userIdList, $workDateFrom='-5 days', $workDateTo='+1 days', $offset = 0, $limit = 50)
    {
        $workDateFrom = date("Y-m-d H:i:s", strtotime($workDateFrom));
        $workDateTo = date("Y-m-d H:i:s", strtotime($workDateTo));

        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/attendance/list?access_token={$access_token}";
        $options = [RequestOptions::JSON => compact(['workDateFrom', 'workDateTo', 'userIdList', 'offset', 'limit'])];
        $response = $client->request('POST', $url,  $options);
        $content = $response->getBody()->getContents();
        echo $content, "\n";
        $recordResult = json_decode($content)->recordresult;
        if(count($recordResult)){
            return $recordResult;
        }
    }

}