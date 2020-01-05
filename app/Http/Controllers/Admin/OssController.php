<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OssController extends Controller
{
    public function index()
    {
        $storage = Storage::disk('oss');
        $res = $storage->putRemoteFile('some/new/place/home-select-fill.png', '/Users/lu/Desktop/home-select-fill.png');
        dd($res);
    }
}
