@extends('fronts.layouts.master')
@section('title', 'Anasayfa')
@section('content')
    @include('fronts.widgets.categoryWidgets')
    <div class="col-md-8 float-left mx-auto">
        @include("fronts.widgets.articleList")
    </div>
@endsection
