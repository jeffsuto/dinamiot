@foreach ($activities as $activity)
    <a href="#" class="list-group-item 
        {{ $activity->color }} {{ ($activity->status == "new" ? "bg-grey bg-lighten-4":"") }}"
        onclick="readNotification('{{ $activity->id }}', '{{ $activity->link }}')">
        <div class="media">
            <div class="media-left valign-middle">
                <i class="{{ $activity->icon }} icon-bg-circle bg-{{ $activity->type }}"></i>
            </div>
            <div class="media-body">
            <h6 class="media-heading">{{ $activity->title }}</h6>
            <p class="notification-text font-small-3 text-muted">{!! $activity->message !!}</p><small>
                <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">{{ $activity->created_at->diffForHumans() }}</time></small>
            </div>
        </div>
    </a>
@endforeach