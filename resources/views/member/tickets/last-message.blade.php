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
