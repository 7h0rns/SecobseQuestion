<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{ $notification->unread() ? '/notifications/'.$notification->id.'?redirect_url=/questions/'.$notification->data['id'] : '/questions/'.$notification->data['id']}}">
        {{ $notification->data['name'] }}对你的提问进行了回答
    </a>
</li>