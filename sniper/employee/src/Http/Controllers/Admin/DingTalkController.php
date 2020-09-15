<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Services\DingTalk;

class DingTalkController
{
    protected $dingTalk = null;

    public function __construct(DingTalk $dingTalk)
    {
        $this->dingTalk = $dingTalk;
    }

    public function departments(Request $request)
    {
        $response = $this->dingTalk->departments();
        return response()->ajax( $response );
    }
}