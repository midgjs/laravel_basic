<div class="border rounded mb-3 p-3">
    {{-- todo <p>{{ $article->title }}</p> --}}
    <p>{{ $article->body }}</p>
    <p><a href="{{ route('profile', ['user' => $article->user->id]) }}">{{ $article->user->name }}</a></p>
    <p class="text-xs text-gray-500">
        <a href="{{ route('articles.show', ['article' => $article->id]) }}">
            {{ $article->created_at->diffForHumans() }}
            <span>댓글 {{ $article->comments_count }} @if($article->recent_comments_exists) (new) @endif</span>
        </a>
    </p>
    <x-article-button-group :article=$article />
</div>