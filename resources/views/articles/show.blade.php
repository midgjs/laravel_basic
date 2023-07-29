<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('상세보기') }}
        </h2>
    </x-slot>

    <div class="container p-5">
        {{ $article->body }}
    </div>
</x-app-layout>