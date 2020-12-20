@foreach ($articles as $article)
    <div class="post-preview">
        <a href="{{ route('single', [$article->getCategory->slug, $article->slug]) }}">
            <h2 class="post-title">
                {{ $article->title }}
            </h2>
            <img src="{{ $article->image }}"
                class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
            <h3 class="post-subtitle">
                {!! substr($article->content, 0, 20) !!}...
            </h3>
        </a>
        <p class="post-meta">
            <a href="#">{{ $article->getCategory->name }}</a>
            {{ $article->created_at->diffForHumans() }}
        </p>
    </div>
    @if (!$loop->last)
        <hr>
    @endif
@endforeach
<!-- Pager -->
{{ $articles->links() }}
