@extends('fronts.layouts.master')
@section('title', $category->name)
@section('content')
    @include('fronts.widgets.categoryWidgets')
    <div class="col-md-8 float-left mx-auto">
        @if (count($articles) > 0)
            @include("fronts.widgets.articleList")

        @else
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">{{ $category->name }}</h4>
                <p>Bu Kategoriye Ait yazı bulunamadı</p>
                <p class="mb-0"></p>
            </div>
        @endif
    </div>
@endsection
  