@extends('fronts.layouts.master')
@section('title', 'İletişim')
@section('bg',
    'https://lh3.googleusercontent.com/proxy/TWfYnz2tih3Jm1KoAjg7NXBZQRaUhvxI947XCKrp4Ns89ujAuVYadOyz13CH1qZ2l2k7AavD7WXqUpCFEP0BBIav2V8TdwcD8gjzP9eZ8Imoal8creHUeyB-pKPrpQ')
@section('content')
    @include('fronts.widgets.categoryWidgets')

    <div class="col-lg-12 col-md-12 mx-auto">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">{{ session('success') }}</h4>
                <p class="mb-0"></p>
            </div>
        @endif
        <p>Bizimle iletişime geçin</p>
        <form method="post" action="{{ route('contact.post') }}">
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Ad Soyad *</label>
                    <input type="text" class="form-control" placeholder="Ad Soyad *" name="name" id="name" required />
                </div>
            </div>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="form-control" placeholder="Email Address *" id="email"
                        required />
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Cep Telefon</label>
                    <input type="tel" class="form-control"  minlength="10" maxlength="10" placeholder="Cep Telefon" name="phone" id="phone"
                        data-validation-required-message="Please enter your phone number.">
                </div>
            </div>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Konu</label>
                    <textarea rows="5" name="message" class="form-control" placeholder="Konu" id="Konu"
                        required /></textarea>
                </div>
            </div>
            <br>
            <div id="success"></div>
            @csrf

            <input type="submit" class="col-12 btn btn-primary" id="sendMessageButton" value="Gönder" />
        </form>
    </div>
    <hr>
@endsection
