@extends("back.layouts.master")
@section('content')
@section('title', 'Silinen Makaleler')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('admin.makaleler.index') }}" class="btn btn-success m-0 font-weight-bold text-white">Aktif
                Makaleler</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fotoğraf</th>
                            <th>Makale Başlığı</th>
                            <th>Kategori</th>
                            <th>Hit</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td><img src='{{ strstr($article->image, 'https') == true ? $article->image : asset($article->image) }}'
                                        width='200' /></td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->getCategory->name }}</td>
                                <td>{{ $article->hit }}</td>
                                <td>{{ $article->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href='{{ route('admin.recover.article', $article->id) }}'
                                        class="btn btn-sm btn-success"><i class="fa fa-undo"></i> </a>
                                    <a href='{{ route('admin.hard.delete.article', $article->id) }}'
                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
