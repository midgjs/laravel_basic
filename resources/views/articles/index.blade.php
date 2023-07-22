<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-red-200">

        <div class="container p-5">
            <h1 class="text-2xl mb-5">글목록</h1>
            @foreach($articles as $article)
                <div class="border rounded mb-3 p-3">
                    {{-- todo <p>{{ $article->title }}</p> --}}
                    <p>{{ $article->body }}</p>
                    <p>{{ $article->user->name }}</p>
                    <p><a href="/articles/{{$article->id}}">{{ $article->created_at->diffForHumans() }}</a></p>
                </div>
            @endforeach
        </div>

        {{-- 페이지네이션 --}}
        <div class="container p-5">
            {{ $articles->links() }}
        </div>

    </body>
</html>