@extends('fronts.layouts.master')
@section('title', $page->title)
@section('content')
@section('bg', $page->image)
    @include('fronts.widgets.categoryWidgets')
    <div class="col-lg-8 col-md-10 mx-auto">
        {{ $page->content }}
    </div>
    <hr>
@endsection
