<?php

namespace BestLang\Base\Http\Controllers\Admin;

use BestLang\Base\Http\Controllers\Controller;
use BestLang\Base\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 0);
        $page_size = $request->input('page_size', 10);

        $page = intval($page);
        $page_size = intval($page_size);

        $query = History::query();
        $total = $query->count();
        $histories = $query
            ->with('user')
            ->orderBy('id', 'desc')
            ->limit($page_size)
            ->offset(($page-1)*$page_size)
            ->get();
        return response()->ajax(compact(['histories', 'total']));
    }
}