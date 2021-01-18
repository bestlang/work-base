<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use BestLang\Base\Models\User;
use Illuminate\Http\Request;

class SubordinateController
{
    public function index(Request $request)
    {
        $user = auth()->user();// instanceof BestLang\Base\Models\User
        return response()->ajax($user);
    }
}
