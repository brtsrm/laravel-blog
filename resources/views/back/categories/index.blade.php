@extends("back.layouts.master")
@section('content')
@section('title', 'Tüm Kategoriler')
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Makale Oluştur</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.create') }}" method="post">
                        <div class="form-group">
                            <label for="">Kategori Adı</label>
                            <input type="text" name="name" id="" class="form-control" aria-describedby="helpId">
                        </div>
                        <input type="submit" name="" value="Kaydet" class="w-100 btn btn-primary" />
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kategor Adi</th>
                                <th>Makale Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($categorys as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->articleCount() }}</td>

                                    <td><input class="statusUpdate" data-id={{ $category->id }} type="checkbox"
                                            data-on="Akif" data-onstyle="success" data-off="Pasif" @if ($category->status == 1) checked
                            @endif data-toggle="toggle"></td>
                            <td>
                                <a data-id="{{ $category->id }}" class="edit-click btn btn-sm btn-primary"
                                    title="Kategoriyi Düzenle"><i class="fa fa-edit"></i></a>
                                <a data-id="{{ $category->id }}" data-category-total="{{ $category->articleCount() }}"
                                    class="delete-click btn btn-sm btn-danger" title="Kategoriyi Sil"><i
                                        class="fa fa-window-close"></i></a>
                            </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Kategori Düzenle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.category.update') }}">
                        <div class="form-group">
                            <label for="">Kategori Adı</label>
                            <input type="text" name="name" id="categoryName" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>
                        <div class="form-group">
                            <label for="">Kategori Slug</label>
                            <input type="text" name="slug" id="categorySlug" class="form-control" placeholder=""
                                aria-describedby="helpId">
                        </div>

                        <input type="hidden" name="id" id="categoryId" value="">

                        @csrf

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Kategori Sil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="articleInformation"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <form method="post" action="{{ route('admin.category.delete') }}">
                        <button type="submit" id="categoryDeleteButtonHide" class="btn btn-primary">Sil</button>
                        <input type="hidden" value="" name="id" id="categoryDelete" />
                        @csrf
                    </form>
                </div>
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
            $(".edit-click").click(function() {

                id = $((this)).data("id");
                $.ajax({
                    type: 'get',
                    data: {
                        id: id
                    },
                    url: "{{ route('admin.category.getData') }}",
                    success: function(e) {

                        $("#editCategory").modal('show');
                        $("#categoryName").val(e.name);
                        $("#categorySlug").val(e.slug);
                        $("#categoryId").val(e.id);


                    }
                })

            });
            $(".delete-click").click(function() {
                $("#deleteCategory").modal('show');
                var information = $(".articleInformation");
                id = $((this)).data("id");
                if (id === 15) {
                    $("#categoryDeleteButtonHide").hide();
                    information.html('Bu kategoriyi silemezsiniz.');
                    return;
                }
                categoryDelete = $("#categoryDelete").val(id);
                totalCategory = $((this)).data("category-total");
                information.html('');
                if (totalCategory > 0) {
                    information.html("Bu kategoriye ait toplamda " + totalCategory +
                        " bulunmaktadır. ");
                }
            });
            $('.statusUpdate').change(function() {
                id = $((this)).data("id");
                status = $(this).prop('checked');
                $.get("{{ route('admin.category.switch') }}", {
                        id: id,
                        status: status
                    },
                    function(data, status) {
                        console.log(data);
                    })
            });
        });

    </script>
@endsection
@endsection
