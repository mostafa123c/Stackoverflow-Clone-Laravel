<div class="dropdown text-end ">
    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="notifications" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('Notifications') }} <span class="badge bg-danger">{{ $unreadCount }}</span>

    </a>
    <ul class="dropdown-menu text-small" aria-labelledby="notifications">
        @foreach($notifications as $notification)
            <li><a class="dropdown-item {{ $notification->unread()? 'bg-light fw-bold' : '' }}" href="{{ $notification->data['url'] }}?notify_id={{ $notification->id }}">
                    <h6>{{ $notification->data ['title'] }}</h6>
                    <p>{{ $notification->data ['body'] }}</p>
                    <p class="text-muted">{{ $notification->created_at->diffForHumans() }}</p>
                </a></li>
        @endforeach
    </ul>
</div>
