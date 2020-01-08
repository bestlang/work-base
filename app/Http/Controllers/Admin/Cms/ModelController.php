<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\FieldType;

class ModelController extends Controller
{
    public function fieldTypes()
    {
        $fieldTypes = FieldType::all();
        return response()->ajax($fieldTypes);
    }
}
