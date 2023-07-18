<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-red-200">
    <form action="/articles" method="POST">
        <div class="container p-5">
            <h1 class="text-2xl">글쓰기</h1>
            @csrf
            <input type="text" class="block w-full mb-2 mt-3 rounded">
            <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
        
        
        </div>
    </form>
    </body>
</html>