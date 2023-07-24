<!DOCTYPE html>
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
                    <p><a href="{{ route('articles.show', ['article' => $article->id]) }}">{{ $article->created_at->diffForHumans() }}</a></p>
                    <div class="flex flex-row mt-2">
                        <p class="mr-1">
                            <a href="{{ route('articles.edit', ['article' => $article->id]) }}" 
                            class="button rounded bg-blue-500 px-2 py-1 text-xs text-white">수정</a>
                        </p>
                        <form action="{{ route('articles.delete', ['article' => $article->id]) }}" method="POST">
                            @csrf
                            {{-- @method('DELETE') --}}
                            <button class="py-1 px-3 bg-red-500 text-white rounded text-xs">삭제</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 페이지네이션 --}}
        <div class="container p-5">
            {{ $articles->links() }}
        </div>

    </body>
</html>