<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-red-200">
        <div class="container p-5">
            <h1 class="text-2xl mb-5">글목록</h1>
            @foreach($articles as $article)
                <div class="border rounded mb-3 p-3">
                    <p>{{ $article->body }}</p>
                    <p>{{ $article->created_at }}</p>
                </div>
            @endforeach
            {{-- <? dd($articles);?> --}}
        </div>
    </body>
</html>