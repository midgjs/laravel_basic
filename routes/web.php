<?php

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/articles/create', function () {
    return view('articles/create');
});

Route::post('/articles', function (Request $request) {
    $input = $request->validate([
        'body' => [
            'required',
            'string',
            'max:255'
        ]
    ]);
    
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

    return 'hello';
});

Route::get('articles', function(Request $request) {
    $perPage = $request->input('per_page', 2);

    $articles = Article::with('user') //eagerloading : user모델 접근시 쿼리실행이 아니고 미리 유저테이블 정보를 한번에 불러온다
    ->select('body', 'user_id', 'created_at')
    ->latest()
    ->paginate($perPage);
    
    $articles->withQueryString();
    // $articles->appends(['filter' =>'name']);

    return view(
        'articles.index', 
        [
            'articles' => $articles,
        ]);

    // return view('articles.index')->with('articles', $articles);
});