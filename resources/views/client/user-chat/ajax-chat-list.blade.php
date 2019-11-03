@forelse($chatDetails as $chatDetail)

    <li class="@if($chatDetail->from == $user->id) odd @else  @endif">
        <div class="chat-image"> <img alt="user" src="@if(is_null($chatDetail->fromUser->image)){{asset('default-profile-2.png')}} @else{{ asset('user-uploads/avatar/'.$chatDetail->fromUser->image)}}@endif"> </div>
        <div class="chat-body">
            <div class="chat-text">
                <h4>@if($chatDetail->from == $user->id) you @else {{$chatDetail->fromUser->name}} @endif</h4>
                <p>{{ $chatDetail->message }}</p>
                <b>{{ $chatDetail->created_at->timezone($global->timezone)->format('d M, h:i A') }}</b>
            </div>
        </div>
    </li>

@empty
    <li><div class="message">@lang('messages.noMessage')</div></li>
@endforelse