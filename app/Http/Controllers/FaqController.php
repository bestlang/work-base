<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function faqs()
    {
        $faqs = Faq::where('in_use', 1)->orderBy('order_factor', 'desc')->get();
        return response()->json(['statusCode'=>'200', 'data' => $faqs], 200);
    }
}
