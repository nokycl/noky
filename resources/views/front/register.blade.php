@extends('layouts.front-app')
@section('content')
    <section class="section bg-img" id="section-contact" style="background-image: url({{ asset('front/img/bg-cup.jpg') }})" data-overlay="8">
        <div class="container">
            <div class="row gap-y">
                <div class="col-12 col-md-6 offset-md-3 form-section">

                    {!! Form::open(['id'=>'register','class'=>'row', 'method'=>'POST']) !!}
                        <div class="col-12 col-md-10 bg-white px-30 py-45 rounded">
                            <p id="alert"></p>
                            <div id="form-box">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company name">
                                </div>
                                <div class="form-group">
                                    <input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="Your Email Address">
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                </div>

                                <div class="g-recaptcha" data-sitekey="{{ $global->google_recaptcha_key }}"></div>
                            <br>

                                <button class="btn btn-lg btn-block btn-primary" type="button" id="save-form">SignUp</button>

                            </div>

                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')
    <script>
        $('#save-form').click(function () {
            @if(!is_null($global->google_recaptcha_key))
                if(grecaptcha.getResponse().length == 0){
                    alert('Please click the reCAPTCHA checkbox');
                    return false;
                }
            @endif

            $.easyAjax({
                url: '{{route('front.signup.store')}}',
                container: '.form-section',
                type: "POST",
                data: $('#register').serialize(),
                messagePosition: "inline",
                success: function (response) {
                    if(response.status == 'success'){
                        $('#form-box').remove();
                    }
                }
            })
        });
    </script>
@endpush
