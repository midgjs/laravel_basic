<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 3);
    
        $articles = Article::with('user') //eagerloading : user모델 접근시 쿼리실행(lazyloading)이 아니고 미리 유저테이블 정보를 한번에 불러온다
            ->withCount('comments')
            ->withExists([
                'comments as recent_comments_exists' => function($query) {
                    $query->where('created_at', '>', Carbon::now()->subDay());
            }])
            ->when(Auth::check(), function($query) {
                $query->whereHas('user', function(Builder $query) {
                    $query->whereIn('id', Auth::user()->followings->pluck('id')->push(Auth::id()));
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    
        // $articles->appends(['filter' =>'name']);
    
        return view('articles.index', 
        [
            'articles' => $articles,
        ]);
    }
}
