@extends("back.layouts.master")
@section('content')
@section('title', 'Tüm Makaleler')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{route('admin.trashed.article')}}" class="btn btn-warning m-0 font-weight-bold text-white">Silinen Makaleler</a>
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
                            <th>Durum</th>
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
                                <td><input class="statusUpdate" data-id={{ $article->id }} type="checkbox" data-on="Akif"
                                        data-onstyle="success" data-off="Pasif" @if ($article->status == 1) checked
                        @endif data-toggle="toggle"></td>
                        <td>

                            <a target="_blank" href='{{route("single",[$article->getCategory->slug,$article->slug])}}' class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
                            <a href='{{ route('admin.makaleler.edit', $article->id) }}' class="btn btn-sm btn-info"><i
                                    class="fa fa-edit"></i></a>
                            <a href='{{route('admin.delete.article',$article->id) }}' class="btn btn-sm btn-danger"><i class="fa fa-window-close"></i></a>

                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.statusUpdate').change(function() {
                id = $((this)).data("id");
                status = $(this).prop('checked');
                $.get("{{ route('admin.switch') }}", {
                        id: id,
                        status: status
                    },
                    function(data, status) {
                        console.log(data);
                    })
            })
        })

    </script>
@endsection
@endsection
