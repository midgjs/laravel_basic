<!DOCTYPE html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-red-200">
    <form action="{{ route('articles.store') }}" method="POST">
        <div class="container p-5">
            <h1 class="text-2xl">글쓰기</h1>
            @csrf
            <input type="text" name="body" class="block w-full mb-2 mt-3 rounded" value="{{ old('body') }}">
            @error('body')
                <p class="text-xs text-red-500 mb-3"> {{ $message }} </p>
            @enderror
            <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>

            {{-- {{ dd($errors->all()) }} --}}
            
        </div>
    </form>
            {{-- {{ dd(request()->old('body')) }} --}}
    </body>
</html>