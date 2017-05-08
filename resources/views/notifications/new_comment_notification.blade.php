<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{ $notification->unread() ? '/notifications/'.$notification->id.'?redirect_url=/questions/'.$notification->data['id'] : '/questions/'.$notification->data['id']}}">
        {{ $notification->data['name'] }}对你的回答进行了评论
    </a>
</li>