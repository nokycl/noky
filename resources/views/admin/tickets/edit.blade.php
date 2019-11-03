@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.tickets.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.update')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
@endpush

@section('content')

    {!! Form::open(['id'=>'updateTicket','class'=>'ajax-form','method'=>'PUT']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-inverse">
                    <div class="panel-heading text-right">@lang('modules.tickets.ticket') # {{ $ticket->id }}

                        <span id="ticket-status">
                            <label class="label
                             @if($ticket->status == 'open')
                                    label-danger
                            @elseif($ticket->status == 'pending')
                                    label-warning
                            @elseif($ticket->status == 'resolved')
                                    label-info
                            @elseif($ticket->status == 'closed')
                                    label-success
                            @endif
                                    ">{{ $ticket->status }}</label>
                        </span>
                    </div>

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body b-b">

                            <div class="row">

                                <div class="col-md-12">
                                    <h4 class="text-capitalize">{{ $ticket->subject }}</h4>

                                    <div class="font-12">{{ $ticket->created_at->format($global->date_format.' '.$global->time_format) }} &bull; {{ ucwords($ticket->requester->name). ' <'.$ticket->requester->email.'>' }}</div>
                                </div>

                                {!! Form::hidden('status', $ticket->status, ['id' => 'status']) !!}

                            </div>
                            <!--/row-->

                        </div>

                        <div id="ticket-messages">

                            @forelse($ticket->reply as $reply)
                                <div class="panel-body b-b">

                                    <div class="row">

                                        <div class="col-xs-2 col-md-1">
                                            {!!  ($reply->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$reply->user->image).'"
                                                                alt="user" class="img-circle" width="40">' : '<img src="'.asset('default-profile-2.png').'"
                                                                alt="user" class="img-circle" width="40">' !!}
                                        </div>
                                        <div class="col-xs-10 col-md-11">
                                            <h4 class="m-t-0"><a
                                                        @if($reply->user->hasRole('employee'))
                                                        href="{{ route('admin.employees.show', $reply->user_id) }}"
                                                        @elseif($reply->user->hasRole('client'))
                                                        href="{{ route('admin.clients.show', $reply->user_id) }}"
                                                        @endif
                                                        class="text-inverse">{{ ucwords($reply->user->name) }} <span
                                                            class="text-muted font-12">{{ $reply->created_at->format($global->date_format.' '.$global->time_format) }}</span></a>
                                            </h4>

                                            <div class="font-light">
                                                {!! ucfirst(nl2br($reply->message)) !!}
                                            </div>
                                        </div>


                                    </div>
                                    <!--/row-->

                                </div>
                            @empty
                                <div class="panel-body b-b">

                                    <div class="row">

                                        <div class="col-md-12">
                                            @lang('messages.noMessage')
                                        </div>

                                    </div>
                                    <!--/row-->

                                </div>
                            @endforelse
                        </div>

                        <div class="panel-body" style="box-shadow: 0 2px 26px -6px rgb(156, 156, 156)">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.tickets.reply') <span
                                                    class="text-danger">*</span></label></label>
                                        <textarea class="textarea_editor form-control" rows="10" name="message"
                                                  id="message"></textarea>
                                    </div>
                                </div>
                                <!--/span-->


                            </div>
                            <!--/row-->

                        </div>


                    </div>

                    <div class="panel-footer text-right">
                        <div class="btn-group dropup m-r-10">
                            <button aria-expanded="true" data-toggle="dropdown"
                                    class="btn btn-info btn-outline dropdown-toggle waves-effect waves-light"
                                    type="button"><i class="fa fa-bolt"></i> @lang('modules.tickets.applyTemplate')
                                <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu">
                                @forelse($templates as $template)
                                    <li><a href="javascript:;" data-template-id="{{ $template->id }}"
                                           class="apply-template">{{ ucfirst($template->reply_heading) }}</a></li>
                                @empty
                                    <li>@lang('messages.noTemplateFound')</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="btn-group dropup">
                            <button aria-expanded="true" data-toggle="dropdown"
                                    class="btn btn-success dropdown-toggle waves-effect waves-light"
                                    type="button">@lang('app.submit') <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu">
                                <li>
                                    <a href="javascript:;" class="submit-ticket" data-status="open">@lang('app.submit')
                                        as Open
                                        <span style="width: 15px; height: 15px;"
                                              class="btn btn-danger btn-small btn-circle">&nbsp;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="submit-ticket"
                                       data-status="pending">@lang('app.submit') as @lang('app.pending')
                                        <span style="width: 15px; height: 15px;"
                                              class="btn btn-warning btn-small btn-circle">&nbsp;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="submit-ticket"
                                       data-status="resolved">@lang('app.submit') as Resolved
                                        <span style="width: 15px; height: 15px;"
                                              class="btn btn-info btn-small btn-circle">&nbsp;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="submit-ticket"
                                       data-status="closed">@lang('app.submit') as Closed
                                        <span style="width: 15px; height: 15px;"
                                              class="btn btn-success btn-small btn-circle">&nbsp;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-4">
                <div class="panel panel-default">

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.tickets.agent')</label>
                                        <select name="agent_id" id="agent_id" class="select2 form-control"
                                                data-style="form-control">
                                            <option value="">Agent not assigned</option>
                                            @forelse($groups as $group)
                                                @if(count($group->enabled_agents) > 0)
                                                    <optgroup label="{{ ucwords($group->group_name) }}">
                                                        @foreach($group->enabled_agents as $agent)
                                                            <option
                                                                    @if($agent->user->id == $ticket->agent_id)
                                                                            selected
                                                                    @endif
                                                                    value="{{ $agent->user->id }}">{{ ucwords($agent->user->name).' ['.$agent->user->email.']' }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @empty
                                                <option value="">@lang('messages.noGroupAdded')</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.invoices.type') <a
                                                    class="btn btn-xs btn-info btn-outline" href="javascript:;"
                                                    id="add-type"><i
                                                        class="fa fa-plus"></i> @lang('modules.tickets.addType')
                                            </a></label>
                                        <select class="form-control selectpicker add-type" name="type_id" id="type_id"
                                                data-style="form-control">
                                            @forelse($types as $type)
                                                <option
                                                        @if($type->id == $ticket->type_id)
                                                        selected
                                                        @endif
                                                        value="{{ $type->id }}">{{ ucwords($type->type) }}</option>
                                            @empty
                                                <option value="">@lang('messages.noTicketTypeAdded')</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.tasks.priority') <span
                                                    class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" name="priority" id="priority"
                                                data-style="form-control">
                                            <option @if($ticket->priority == 'low') selected @endif>low</option>
                                            <option @if($ticket->priority == 'medium') selected @endif>medium</option>
                                            <option @if($ticket->priority == 'high') selected @endif>high</option>
                                            <option @if($ticket->priority == 'urgent') selected @endif>urgent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.tickets.channelName') <a
                                                    class="btn btn-xs btn-info btn-outline" href="javascript:;"
                                                    id="add-channel"><i
                                                        class="fa fa-plus"></i> @lang('modules.tickets.addChannel')</a></label>
                                        <select class="form-control selectpicker" name="channel_id" id="channel_id"
                                                data-style="form-control">
                                            @forelse($channels as $channel)
                                                <option value="{{ $channel->id }}"
                                                        @if($channel->id == $ticket->channel_id)
                                                        selected
                                                        @endif
                                                >{{ ucwords($channel->channel_name) }}</option>
                                            @empty
                                                <option value="">@lang('messages.noTicketChannelAdded')</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.tickets.tags')</label>
                                        <select multiple data-role="tagsinput" name="tags[]" id="tags">
                                            @foreach($ticket->tags as $tag)
                                                <option value="{{ $tag->tag->tag_name }}">{{ $tag->tag->tag_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!--/span-->

                            </div>
                            <!--/row-->

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- .row -->
    </div>
    {!! Form::close() !!}

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="ticketModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection


@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script>
    $('.textarea_editor').wysihtml5();

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    $('.apply-template').click(function () {
        var templateId = $(this).data('template-id');
        var token = '{{ csrf_token() }}';

        $.easyAjax({
            url: '{{route('admin.replyTemplates.fetchTemplate')}}',
            type: "POST",
            data: {_token: token, templateId: templateId},
            success: function (response) {
                if (response.status == "success") {
                    var editorObj = $("#message").data('wysihtml5');
                    var editor = editorObj.editor;
                    editor.setValue(response.replyText);
                }
            }
        })
    })


    $('.submit-ticket').click(function () {

        var status = $(this).data('status');
        $('#status').val(status);

        $.easyAjax({
            url: '{{route('admin.tickets.update', $ticket->id)}}',
            container: '#updateTicket',
            type: "PUT",
            data: $('#updateTicket').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#scroll-here').remove();

                    if(response.lastMessage != null){
                        $('#ticket-messages').append(response.lastMessage);
                    }
                    $('#message').data("wysihtml5").editor.clear();

                    // update status on top
                    if(status == 'open')
                        $('#ticket-status').html('<label class="label label-danger">'+status+'</label>');
                    else if(status == 'pending')
                        $('#ticket-status').html('<label class="label label-warning">'+status+'</label>');
                    else if(status == 'resolved')
                        $('#ticket-status').html('<label class="label label-info">'+status+'</label>');
                    else if(status == 'closed')
                        $('#ticket-status').html('<label class="label label-success">'+status+'</label>');

                    scrollChat();
                }
            }
        })
    });

    $('#add-type').click(function () {
        var url = '{{ route("admin.ticketTypes.createModal")}}';
        $('#modelHeading').html("{{ __('app.addNew').' '.__('modules.tickets.ticketTypes') }}");
        $.ajaxModal('#ticketModal', url);
    })

    $('#add-channel').click(function () {
        var url = '{{ route("admin.ticketChannels.createModal")}}';
        $('#modelHeading').html("{{ __('app.addNew').' '.__('modules.tickets.ticketTypes') }}");
        $.ajaxModal('#ticketModal', url);
    })

    function setValueInForm(id, data) {
        $('#' + id).html(data);
        $('#' + id).selectpicker('refresh');
    }

    function scrollChat() {
        $('#ticket-messages').animate({
            scrollTop: $('#ticket-messages')[0].scrollHeight
        }, 'slow');
    }

    scrollChat();
</script>
@endpush