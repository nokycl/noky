@extends('layouts.member-app')

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
                <li><a href="{{ route('member.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('member.tickets.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.update')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">
@endpush

@section('content')

    {!! Form::open(['id'=>'updateTicket','class'=>'ajax-form','method'=>'PUT']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
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

                                    <div class="font-12">{{ $ticket->created_at->format($global->date_format .' '.$global->time_format) }} &bull; {{ ucwords($ticket->requester->name). ' <'.$ticket->requester->email.'>' }}</div>
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
                                                        href="{{ route('member.employees.show', $reply->user_id) }}"
                                                        @elseif($reply->user->hasRole('client'))
                                                        href="{{ route('member.clients.show', $reply->user_id) }}"
                                                        @endif
                                                        class="text-inverse">{{ ucwords($reply->user->name) }} <span
                                                            class="text-muted font-12">{{ $reply->created_at->format($global->date_format .' '.$global->time_format) }}</span></a>
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

                        @if($ticket->status != 'closed')

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
                        @endif


                    </div>

                    <div class="panel-footer text-right">
                        @if($ticket->status != 'closed')
                        <div class="btn-group dropup">
                            <button class="btn btn-danger m-r-10" id="close-ticket" type="button"><i class="fa fa-ban"></i> @lang('modules.tickets.closeTicket') </button>
                            <button class="btn btn-success" id="submit-ticket" type="button">@lang('app.submit') </button>
                        </div>
                        @else
                            <div class="btn-group dropup">
                                <button class="btn btn-success m-r-10" id="reopen-ticket" type="button"><i class="fa fa-refresh"></i> @lang('modules.tickets.reopenTicket') </button>
                            </div>
                        @endif

                    </div>
                </div>


            </div>
        </div>
        <!-- .row -->
    </div>
    {!! Form::close() !!}


@endsection


@push('footer-script')
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script>
    $('.textarea_editor').wysihtml5();

    $('#submit-ticket').click(function () {

        $.easyAjax({
            url: '{{route('member.tickets.update', $ticket->id)}}',
            container: '#updateTicket',
            type: "PUT",
            data: $('#updateTicket').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#scroll-here').remove();
                    $('#ticket-messages').append(response.lastMessage);
                    $('#message').data("wysihtml5").editor.clear();

                    scrollChat();
                }
            }
        })
    });

    $('#close-ticket').click(function () {

        $.easyAjax({
            url: '{{route('member.tickets.closeTicket', $ticket->id)}}',
            type: "POST",
            data: {'_token': "{{ csrf_token() }}"}
        })
    });

    $('#reopen-ticket').click(function () {

        $.easyAjax({
            url: '{{route('member.tickets.reopenTicket', $ticket->id)}}',
            type: "POST",
            data: {'_token': "{{ csrf_token() }}"}
        })
    });

    function scrollChat() {
        $('#ticket-messages').animate({
            scrollTop: $('#ticket-messages')[0].scrollHeight
        }, 'slow');
    }

    scrollChat();
</script>
@endpush