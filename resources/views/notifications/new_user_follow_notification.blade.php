<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="profile/{{ $notification->data['name'] }}">{{ $notification->data['name'] }}</a>关注了你
</li>