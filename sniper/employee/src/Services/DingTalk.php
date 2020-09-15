<?php
namespace Sniper\Employee\Services;

use GuzzleHttp\Client;

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
        return json_decode($content)->access_token;
    }

    public function departments()
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
        return ['departments' => $departments[$rootKey], 'departmentIds' => $departmentIds];
    }

    public function _getDepartmentUsers($departmentId)
    {
        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/user/simplelist?access_token={$access_token}&department_id={$departmentId}";
        $response = $client->request('GET', $url, ['offset' => 0, 'size' => 100]);
        $content = $response->getBody()->getContents();
        $users = json_decode($content)->userlist;
        return $users;
    }

    public function _getUserAttendance($userIds, $offset = 0, $limit = 50)
    {
        $workDateFrom = date("Y-m-d H:i:s", strtotime("-30 days"));
        $workDateTo = date("Y-m-d H:i:s", strtotime("+1 days"));
        $userIdList = $userIds;

        $access_token = $this->_getAccessToken();
        $client = new Client();
        $url = "https://oapi.dingtalk.com/attendance/list?access_token={$access_token}";
        $response = $client->request('POST', $url, compact(['workDateFrom', 'workDateTo', 'userIdList', 'offset', 'limit']));
        $content = $response->getBody()->getContents();
        echo $content;
        $recordResult = json_decode($content)->recordresult;
        return $recordResult;
    }

}