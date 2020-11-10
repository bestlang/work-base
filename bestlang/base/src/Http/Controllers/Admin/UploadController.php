<?php
namespace BestLang\Base\Http\Controllers\Admin;

use Illuminate\Http\Request;
use BestLang\Base\Http\Controllers\Controller;
use Storage;

class UploadController extends Controller
{

    public function index(Request $request)
    {
        $file = $request->file('file');
        $path = Storage::putFileAs(
            'uploads', $file, randomStr().'_'.$file->getClientOriginalName()
        );
        return response()->ajax(['file' => Storage::url($path)]);
    }
}
