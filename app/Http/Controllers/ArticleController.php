<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ArticleController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function create() {
        return view('articles/create');
    }

    public function store(CreateArticleRequest $request) {
        $input = $request->validated();
        
        /* 1. php
        // db접속정보
        $host = config('database.connections.mysql.host');
        $dbname = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
    
        // pdo 객체생성
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("INSERT INTO articles (body, user_id) values(:body, :userId)");
    
        // 쿼리 값을 설정
        $stmt->bindValue(':body', $input['body']);
        $stmt->bindValue(':userId', Auth::id());
        
        // 실행
        $stmt->execute();
        */
    
        /* 2. DB파사드 사용
        DB::statement("INSERT INTO articles (body, user_id) values(:body, :userId)", ['body' => $input['body'], 'userId' => Auth::id()]);
        */
    
        /* 3. 쿼리빌더 사용
        DB::table('articles')->insert([
            'body' => $input['body'],
            'user_id' => Auth::id()
        ]);
        */
    
        // 4. Eloquent ORM
        // $article = new Article;
        // $article->body = $input['body'];
        // $article->user_id = Auth::id();
        // $article->save();
    
        // 5. Eloquent ORM / fillable 적용방식(model에 추가)
        Article::create([
            'body' => $input['body'],
            'user_id' => Auth::id()
        ]);
    
        return redirect()->route('articles.index');
    }

    public function index(Request $request) {
        $perPage = $request->input('per_page', 3);
        
        $search = $request->input('search');

        $articles = Article::with('user') //eagerloading : user모델 접근시 쿼리실행(lazyloading)이 아니고 미리 유저테이블 정보를 한번에 불러온다
            ->withCount('comments')
            ->withExists([
                'comments as recent_comments_exists' => function($query) {
                    $query->where('created_at', '>', Carbon::now()->subDay());
            }])
            ->when($search, function($query, $search) {
                $query->where('body', 'like', "%$search%")
                ->orWhereHas('user', function(Builder $query) use ($search) {
                    $query->where('username', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    
        // $articles->appends(['filter' =>'name']);
    
        return view('articles.index', 
        [
            'articles' => $articles,
            'search' => $search,
        ]);
    
        // return view('articles.index')->with('articles', $articles);
    }
    
    public function show(Article $article) {
        $article->load('comments.user');
        $article->loadCount('comments');
        
        return view('articles.show', ['article' => $article]);
    }

    public function edit(EditArticleRequest $request, Article $article) {

        return view('articles.edit', ['article' => $article]);
    }

    public function update(UpdateArticleRequest $request, Article $article) {

        $input = $request->validated();
    
        $article->body = $input['body'];
        $article->save();
    
        return redirect()->route('articles.index');
    }

    public function delete(DeleteArticleRequest $request, Article $article) {

        $article->delete();
    
        return redirect()->route('articles.index');
    }
}
