<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.featureSetting.editFeature')</h4>
</div>

{!!  Form::open(['url' => '' ,'method' => 'put', 'id' => 'add-edit-form','class'=>'form-horizontal']) 	 !!}
<div class="modal-body">
    <div class="box-body">
        @if(isset($type) && $type == 'icon')
            <div class="form-group">
                <label class="col-sm-2 control-label">@lang('app.icon')</label>
                <div class="btn-group col-sm-10">
                    <button type="button" class="btn btn-primary " id="iconButton"><i
                                class="{{ $feature->icon }}"></i></button>
                    <button data-selected="graduation-cap" type="button"
                            class="icp icp-dd btn btn-primary dropdown-toggle iconpicker-component col-sm-1"
                            data-toggle="dropdown">
                        <i style="display: none" class=""></i>
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu"></div>
                </div>
                <input class="" value="{{ $feature->icon }}"  name="icon"  id="iconInput" type="hidden"/>
            </div>
        @endif
            <input class="" name="type" id="type" value="{{ $type }}" type="hidden"/>

            <div class="form-group">
            <label class="col-sm-2 control-label" for="name">@lang('app.title')</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" name="title" value="{{ $feature->title }}">
                <div class="form-control-focus"> </div>
                <span class="help-block"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">@lang('app.description')</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control summernote" id="description" rows="3" name="description" > {!! $feature->description !!} </textarea>
                <div class="form-control-focus"> </div>
                <span class="help-block"></span>
            </div>
        </div>
        @if(isset($type) && $type == 'image')
            <div class="form-group">
                <label class="col-sm-2 control-label" for="exampleInputPassword1">@lang('app.image') </label>
                <div class="col-sm-10">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail"
                             style="width: 200px; height: 150px;">
                            @if(is_null($feature->image))
                                <img src="{{asset('front/img/demo/slack/tools.png')}}"
                                     alt=""/>
                            @else
                                <img src="{{ asset('user-uploads/front/feature/'.$feature->image) }}"
                                     alt=""/>
                            @endif
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"
                             style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                                    <span class="btn btn-info btn-file">
                                        <span class="fileinput-new"> @lang('app.selectImage') </span>
                                        <span class="fileinput-exists"> @lang('app.change') </span>
                                        <input type="file" name="image" id="image"> </span>
                            <a href="javascript:;" class="btn btn-danger fileinput-exists"
                               data-dismiss="fileinput"> @lang('app.remove') </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-sm-offset-2 col-sm-10 ">
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> @lang('messages.FeatureImageSizeMessage')</div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="modal-footer">
    <button id="save" type="button" class="btn btn-custom">@lang('app.submit')</button>
</div>
{{ Form::close() }}
<script src="{{ asset('plugins/iconpicker/js/fontawesome-iconpicker.js') }}"></script>
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>

<script>
    $('.summernote').summernote({
        height: 150,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false                 // set focus to editable area after initializing summernote
    });
    $(function () {
        $('.icp-dd').iconpicker({
            title: 'Dropdown with picker',
            component:'.btn > i',
            templates: {
                iconpickerItem: '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>'
            }
        });

        $('.icp').on('iconpickerSelected', function (e) {
            $('#iconInput').val(e.iconpickerValue);
            $('#iconButton').html('<i  class="'+e.iconpickerValue+'"></i></button>');
        });
    });
    $('#save').click(function () {
        var url = '{{ route('super-admin.feature-settings.update', $feature->id)}}';
        $.easyAjax({
            url: url,
            container: '#add-edit-form',
            type: "POST",
            file:true,
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
        return false;
    })
</script>

