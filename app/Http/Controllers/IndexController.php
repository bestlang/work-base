<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\AES128;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class IndexController extends Controller
{
    public function testPermissionGuard(Request $request)
    {
        $permission = Permission::create(['name' => 'what is the guard of me']);
    }

}
