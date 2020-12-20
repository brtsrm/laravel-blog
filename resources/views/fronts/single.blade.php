@extends('fronts.layouts.master')
@section('title', $article->title)
@section('content')
@section('bg', strstr('http', $article->image) ? $article->image : asset($article->image))
    @include('fronts.widgets.categoryWidgets')
    
    <div class="col-lg-8 col-md-10 mx-auto">
        {!! $article->content !!}
    </div>
    <hr>
@endsection
