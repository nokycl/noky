@foreach($members as $member)
    <option value="{{ $member->user_id }}">{{ ucwords($member->user->name) }}</option>
@endforeach