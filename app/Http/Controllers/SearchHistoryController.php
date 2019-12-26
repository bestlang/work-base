<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchHistoryController extends Controller
{
    //
    public function record(Request $request)
    {
        $keyword = $request->input('keyword');
        if($keyword) {
            $query = auth()->user()->searchHistories();
            $record = $query->firstOrCreate(['keyword'=>$keyword]);
            $record->increment('counts');
        }
        return response()->json(['statusCode'=>'200', 'message'=>'ok']);
    }

    public function hotWords()
    {
        $result = SearchHistory::query()->select(DB::raw('count(1) as search_count, keyword'))->groupBy('keyword')->orderBy('search_count', 'desc')->limit(5)->get();
        return response()->json(['statusCode'=>'200', 'data'=>['hotWords'=>$result]]);
    }
}
