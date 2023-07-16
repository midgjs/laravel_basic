<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-blue-300">
        <form action="/articles" method="POST">
            <h1>글쓰기</h1>

            <input type="text">
            <input type="button" value="저장하기">



        </form>
    </body>
</html>