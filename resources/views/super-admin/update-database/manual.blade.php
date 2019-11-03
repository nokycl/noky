@extends('layouts.super-admin')

@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">
<style>
    .file-bg {
        height: 150px;
        overflow: hidden;
        position: relative;
    }

    .file-bg .overlay-file-box {
        opacity: .9;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        text-align: center;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">{{ __($pageTitle) }}</div>

            <div class="vtabs customvtab m-t-10">

                @include('sections.super_admin_setting_menu')

                <div class="tab-content">
                    <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('super-admin.update-settings.index') }}" class="btn btn-warning btn-sm btn-outline "><i class="fa fa-arrow-left"></i> @lang('app.back')</a>
                                </div>
                            </div>

                            @if(isset($lastVersion))
                             <!--row-->
                             <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="box-title" id="structure">@lang('modules.update.updateManual')</h4>
                                    </div>
    
                                    <div class="col-md-12">
                                        <h4 class="box-title text-info">Step 1</h4>
                                        <a href="https://worksuite.biz/updates/saas-updates/download.php?{{ $encryptedDownloadLink }}" target="_blank" class="btn btn-success btn-sm btn-outline">@lang('modules.update.downloadUpdateFile') <i class="fa fa-download"></i></a>
                                    </div>
    
                                    <div class="col-md-12 m-t-20">
                                            <h4 class="box-title text-info">Step 2</h4>
                                            <form action="{{ route('super-admin.update-settings.store') }}" class="dropzone" id="file-upload-dropzone">
                                            {{ csrf_field() }}
    
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>
                                        </form>
                                    </div>
    
                                    <div class="col-md-12 m-t-20" id="install-process">
                                       
                                    </div>
    
                                    <div class="col-md-12 m-t-20">
                                        <h4 class="box-title text-info">Step 3</h4>
                                        <h4 class="box-title">@lang('modules.update.updateFiles')</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group" id="files-list">
                                            @foreach (\Illuminate\Support\Facades\File::files($updateFilePath) as $key=>$filename)
                                            <li class="list-group-item" id="file-{{ $key+1 }}">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            {{ \Illuminate\Support\Facades\File::basename($filename) }}
                                                        </div>
                                                        <div class="col-md-3 text-right">
                                                            <button type="button" class="btn btn-success btn-sm btn-outline install-files" data-file-no="{{ $key+1 }}" data-file-path="{{ $filename }}">@lang('modules.update.install') <i class="fa fa-refresh"></i></button>
    
                                                            <button type="button" class="btn btn-danger btn-sm btn-outline delete-files" data-file-no="{{ $key+1 }}" data-file-path="{{ $filename }}">@lang('app.delete') <i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
    
    
    
                                </div>
                                <!--/row-->
                            @else
                                <div class="row">
                                    <div class="col-md-12 m-t-20">
                                        <div class="alert alert-success ">
                                                You have latest version of this app.
                                        </div>
                                    </div>
                                </div>
                            @endif

                    </div>
                </div>

            </div>
        </div>


    </div>
    <!-- .row -->

    @endsection

    @push('footer-script')
    <script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>
    <script type="text/javascript">
        // "myAwesomeDropzone" is the camelized version of the HTML element's ID
        Dropzone.options.fileUploadDropzone = {
            paramName: "file", // The name that will be used to transfer the file
    //        maxFilesize: 2, // MB,
            dictDefaultMessage: "Upload or drop the downloaded file here",
            accept: function (file, done) {
                done();
            },
            init: function () {
                this.on("success", function (file, response) {
                    var viewName = $('#view').val();
                    if(viewName == 'list') {
                        $('#files-list-panel ul.list-group').html(response.html);
                    } else {
                        $('#thumbnail').empty();
                        $(response.html).hide().appendTo("#thumbnail").fadeIn(500);
                    }
                })
            }
        };



        var updateAreaDiv = $('#update-area');
        var refreshPercent = 0;
        var checkInstall = true;

        function checkIfFileExtracted(){
            $.easyAjax({
                type: 'GET',
                url: '{!! route("admin.updateVersion.checkIfFileExtracted") !!}',
                success: function (response) {
                    checkInstall = false;
                    $('#download-progress').append("<br><i><span class='text-success'>Installed successfully. Reload page to see the changes.</span>.</i>");
                    document.getElementById('logout-form').submit();
                }
            });
        }

        $('.install-files').click(function(){
            $('#install-process').html('<div class="alert alert-info ">Installing...Please wait (This may take few minutes.)</div>');
            window.setInterval(function(){
                /// call your function here
                if(checkInstall == true){
                    checkIfFileExtracted();
                    console.log("install check");
                }
            }, 1500);
            console.log("install start");
            
            let filePath = $(this).data('file-path');
            $.easyAjax({
                type: 'GET',
                url: '{!! route("super-admin.update-settings.install") !!}',
                data: {filePath: filePath},
                success: function (response) {
                    $('#download-progress').append("<br><i><span class='text-success'>Installed successfully. Reload page to see the changes.</span>.</i>");
                    document.getElementById('logout-form').submit();
                }
            });
        });

        $('.delete-files').click(function(){
            let filePath = $(this).data('file-path');
            let fileNumber = $(this).data('file-no');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                   
                    $.easyAjax({
                        type: 'POST',
                        url: '{!! route("super-admin.update-settings.deleteFile") !!}',
                        data: {"_token": "{{ csrf_token() }}", filePath: filePath},
                        success: function (response) {
                            $('#file-'+fileNumber).remove();
                        }
                    });
                }
            });
        });
    </script>
    @endpush