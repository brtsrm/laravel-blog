@isset($categorys)
    <div class=" col-md-4">
        <ul class="col-md-12">
            @foreach ($categorys as $category)
                <li class="list-group-item d-flex @if(Request::segment(2) == $category->slug) active @endif justify-content-between align-items-center">
                    <a href="{{route("category",$category->slug)}}">
                        {{ $category->name }}
                    </a>
                    <span class="badge badge-info badge-pill pull-right">{{ $category->articleCount() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endisset
