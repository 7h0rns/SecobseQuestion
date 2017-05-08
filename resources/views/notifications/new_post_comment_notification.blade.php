<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{ $notification->unread() ? '/notifications/'.$notification->id.'?redirect_url=/posts/'.$notification->data['id'] : '/posts/'.$notification->data['id']}}">
        {{ $notification->data['name'] }}对你的文章进行了评论
    </a>
</li>