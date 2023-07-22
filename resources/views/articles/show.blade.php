<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-red-200">

        <div class="container p-5">
            {{ $article->body }}
        </div>

    </body>
</html>