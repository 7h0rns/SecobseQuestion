<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{ $notification->unread() ? '/notifications/'.$notification->id.'?redirect_url=/profile/'.$notification->data['name']
        : '/profile/'.$notification->data['name']}}">
        {{ $notification->data['name'] }}</a>关注了你
</li>