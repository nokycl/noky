@extends('layouts.front-app')
@section('content')
    <style>
        .has-danger .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #ff4954;
        }
    </style>
    <section class="section bg-img" id="section-contact" style="background-image: url({{ asset('front/img/bg-cup.jpg') }})" data-overlay="8">
        <div class="container">
            <div class="row gap-y">
                <div class="col-12 col-md-6 offset-md-3 form-section">
                    <div class="col-12 col-md-10 bg-white px-30 py-45 rounded">
                        <div class="alert alert-{{$class}}">
                            {!! $messsage !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')
    <script>
        $('#save-form').click(function () {
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
