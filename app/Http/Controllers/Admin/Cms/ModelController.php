<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Cms\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\FieldType;

class ModelController extends Controller
{
    public function index()
    {
        $models = Model::all();
        return response()->ajax($models);
    }
}
