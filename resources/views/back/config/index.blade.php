@extends("back.layouts.master")
@section('content')
@section('title', 'Ayarlar ')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action={{route('admin.config.setting.post')}}>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Site Başlığı</label>
                            <input type="text" value="{{$config->title}}" name="site_title" id="" class="form-control"
                                placeholder="" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Site Durumu</label><br />
                            <input class="statusUpdate" type="checkbox" name="site_durumu" data-on="Akif"
                                data-onstyle="success" data-off="Pasif" @if ($config->active == 1) checked
                            @endif data-toggle="toggle">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Site Icon</label>
                            <input type="file" class="form-control" name="site_favicon" accept="image/x-icon" id="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Site Logo</label>
                            <input type="file" class="form-control" name="site_logo" accept="image/*" id="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Linkedin Adresi</label>
                            <input type="text" value="{{$config->linkedin}}" name="site_linkedin" id=""
                                class="form-control" placeholder="" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Github Adresi</label>
                            <input type="text" value="{{$config->github}}" name="site_github" id="" class="form-control"
                                placeholder="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Site Açıklaması</label>
                        <input type="text" value="{{$config->description}}" name="site_aciklamasi" id="site_aciklamasi"
                            class="form-control" maxlength="300" placeholder="" />
                        <small id="helpId" class="form-text text-muted">En Fazla <strong id="harfSayisi">300</strong>
                            Harf yazabilirsiniz.</small>
                    </div>
                    <div class="row">
                        <input class=" form-control m-3 btn btn-primary" type="submit" value="Kaydet" />
                    </div>
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
    $("#site_aciklamasi").keyup(function(){
        var maksimum=300;
        this.value=this.value.substr(0,maksimum);
        var kalan= maksimum-this.value.length;
        $("#harfSayisi").html(kalan);
        
    });

</script>
@endsection
@endsection