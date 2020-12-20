@extends("back.layouts.master")
@section('content')
@section('title', 'Makaleler Oluştur')
    <div class="card shadow mb-4">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Hata</h4>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="card-body">
            <form method="post" action="{{ route('admin.makaleler.store') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Makele Başlığı</label>
                    <input type="text" required name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label>Makele Kategori</label>
                    <select name="category" class="form-control" id="">
                        <option value="" selected disabled>Seçim yapınız</option>
                        @foreach ($categorys as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Makele Fotoğrafı</label>
                    <input type="file" name="image" accept="image/*" id="">
                </div>
                <div class="form-group">
                    <label>Makele İçerik</label>
                    <textarea name="content" class="form-control" id="editor" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">

                    <button type="submit" class="btn btn-info float-right">Makaleyi Oluştur</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                height: 300,
            });
        });

    </script>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@endsection
