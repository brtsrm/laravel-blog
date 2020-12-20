@extends("back.layouts.master")
@section('content')
@section('title', 'Tüm Makaleler')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <div style="display:none" id="successOrder" class="alert alert-success">
                Başarılı şekilde taşıma yapıldı
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sıralama</th>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="orders">
                    @foreach ($pages as $page)
                        <tr id="page_{{ $page->id }}">
                            <td><i class="fas fa-arrows-alt-v handle"></i></td>
                            <td><img src='{{ strstr($page->image, 'https') == true ? $page->image : asset($page->image) }}'
                                    width='200' /></td>
                            <td>{{ $page->title }}</td>

                            <td><input class="statusUpdate" data-id={{ $page->id }} type="checkbox" data-on="Akif"
                                    data-onstyle="success" data-off="Pasif" @if ($page->statu == 1) checked
                    @endif data-toggle="toggle"></td>
                    <td>
                        <a target="_blank" href='{{ route('page', $page->slug) }}/' class="btn btn-sm btn-success"><i
                                class="fa fa-eye"></i> </a>

                        <a title="edit" href='{{ route('admin.page.edit', $page->id) }}' class="btn btn-sm btn-info"><i
                                class="fa fa-edit"></i></a>

                        <a title="delete" href='{{ route('admin.page.delete', $page->id) }}'
                            class="btn btn-sm btn-danger"><i class="fa fa-window-close"></i></a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $("#orders").sortable({
            handle: '.handle',
            update: function() {
                var siralama = $('#orders').sortable('serialize');
                $.get("{{ route('admin.page.orders') }}?" + siralama, function(e) {

                    setTimeout(function() {
                        $("#successOrder").show();

                    },1000);

                });
            }
        });
        $(function() {
            $('.statusUpdate').change(function() {
                id = $((this)).data("id");
                status = $(this).prop('checked');
                $.get("{{ route('admin.page.switch') }}", {
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
