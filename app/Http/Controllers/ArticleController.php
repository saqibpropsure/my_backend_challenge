<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request){
        $articles = Article::when(isset($request->category) && !empty($request->category), function($query) use ($request) {
            $query->where('category', 'like', '%'. $request->category . '%');
        })
        ->when(isset($request->date) && !empty($request->date), function($query) use ($request) {
            $query->where('published_at', '=', $request->date);
        })
        ->when(isset($request->source) && !empty($request->source), function($query) use ($request) {
            $query->where('end_point', 'like', '%'. $request->source . '%');
        })->get();

        return response()->json([
            'status'    => 'OK',
            'success'   => true,
            'message'   => 'Articles Data',
            'articles'  => $articles
        ]);
    }
}
