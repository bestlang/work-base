<?php
/*钉钉应用（小程序）*/
return [
    'AgentId' => 877237504,
    'AppKey' => 'dingmjfggqzoshuxdfcx',
    'AppSecret' => 'iRkJxH89pvoyFYXL2g6lcZWYWkoDDTa1c7g65HI1u_gb0zCDvdMHFxoCML3iu5tC'
];
//获取access_token
//  curl  'https://oapi.dingtalk.com/gettoken?appkey=dingmjfggqzoshuxdfcx&appsecret=iRkJxH89pvoyFYXL2g6lcZWYWkoDDTa1c7g65HI1u_gb0zCDvdMHFxoCML3iu5tC'

// 获取部门列表
// curl  'https://oapi.dingtalk.com/department/list?access_token=27c21eccafdc35acb75d15134947f593'

// curl -d {"workDateFrom": "2020-08-01 06:00:00", "workDateTo": "2020-09-01 00:00:00","userIdList":[], "offset":0, "limit":1} 'https://oapi.dingtalk.com/attendance/list?access_token=27c21eccafdc35acb75d15134947f593'



// curl  'https://oapi.dingtalk.com/user/simplelist?access_token=27c21eccafdc35acb75d15134947f593&department_id=1'