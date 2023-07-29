<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('글 수정하기') }}
        </h2>
    </x-slot>
    
    <form action="{{ route('articles.update', ['article' => $article->id]) }}" method="POST">
        <div class="container p-5">
            @csrf
            {{-- <input type="hidden" name="_method" value="PUT"> --}}
            {{-- @method('PUT') --}}
            <input type="text" name="body" class="block w-full mb-2 mt-3 rounded" value="{{ old('body') ?? $article->body }}">
            @error('body')
                <p class="text-xs text-red-500 mb-3"> {{ $message }} </p>
            @enderror
            <button class="py-1 px-3 bg-black text-white rounded text-xs">수정하기</button>

            {{-- {{ dd($errors->all()) }} --}}
            
        </div>
    </form>
            {{-- {{ dd(request()->old('body')) }} --}}
</x-app-layout>