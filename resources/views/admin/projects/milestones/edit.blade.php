<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><i class="fa fa-flag"></i> @lang('app.update') @lang('modules.projects.milestones')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['id'=>'updateTime','class'=>'ajax-form','method'=>'PUT']) !!}
                <div class="form-body">
                        <div class="row">
                                <div class="col-md-12">

                                    {!! Form::hidden('project_id', $milestone->project_id) !!}

                                    <div class="form-body">
                                        <div class="row m-t-30">
                                            
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label>@lang('modules.projects.milestoneTitle')</label>
                                                    <input id="milestone_title" name="milestone_title" type="text"
                                                class="form-control" value="{{ $milestone->milestone_title }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>@lang('app.status')</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option 
                                                            @if($milestone->status == 'incomplete') selected @endif
                                                            value="incomplete">@lang('app.incomplete')</option>
                                                            <option 
                                                            @if($milestone->status == 'complete') selected @endif
                                                            value="complete">@lang('app.complete')</option>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>@lang('modules.invoices.currency')</label>
                                                        <select name="currency_id" id="currency_id" class="form-control">
                                                            <option value="">--</option>
                                                            @foreach ($currencies as $item)
                                                                <option 
                                                                @if($item->id == $milestone->currency_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->currency_code.' ('.$item->currency_symbol.')' }}</option>           
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label>@lang('modules.projects.milestoneCost')</label>
                                                    <input id="cost" name="cost" type="number" value="{{ $milestone->cost }}"
                                                           class="form-control" value="0" min="0" step=".01">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        

                                        <div class="row m-t-20">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="memo">@lang('modules.projects.milestoneSummary')</label>
                                                    <textarea name="summary" id="" rows="4" class="form-control">{{ $milestone->summary }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                

                                    <hr>
                                </div>
                            </div>
                </div>
                <div class="form-actions m-t-30">
                    <button type="button" id="update-form" class="btn btn-success"><i class="fa fa-check"></i> Save
                    </button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    </div>
</div>


<script>


    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.milestones.update', $milestone->id)}}',
            container: '#updateTime',
            type: "POST",
            data: $('#updateTime').serialize(),
            success: function (response) {
                $('#editTimeLogModal').modal('hide');
                table._fnDraw();
            }
        })
    });
</script>