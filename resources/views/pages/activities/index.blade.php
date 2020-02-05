@extends('layout.app')

@section('breadcrumbs', Breadcrumbs::render('activities'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-grey bg-lighten-4">
                <div class="card-header">
                    <div class="card-title">
                        List of Activities
                    </div>
                    <div class="heading-elements">
						<button class="btn btn-info read-btn">Read all</button>
					</div>
                </div>
                <div class="card-body">
                    <ul class="list-group scroll height-450 activity-container">
                        @foreach ($activities as $activity)
                            <a onclick="readNotification('{{ $activity->id }}', '{{ $activity->link }}')" href="javascript:void(0)" class="list-group-item {{ $activity->color }} {{ ($activity->status == "new" ? "bg-grey bg-lighten-4":"") }}">
                                <div class="media">
                                    <div class="media-left valign-middle"><i class="{{ $activity->icon }} font-medium-4 icon-bg-circle bg-{{ $activity->type }}"></i></div>
                                    <div class="media-body">
                                        <h6 class="media-heading">{{ $activity->title }}</h6>
                                        <p class="notification-text font-small-3 text-muted">{!! $activity->message !!}</p><small>
                                        <time datetime="{{ $activity->created_at }}" class="media-meta text-muted">{{ $activity->created_at->diffForHumans() }}</time></small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
    
        $('.read-btn').click(function(){
            $.ajax({
                url: "{{ route('api.v1.activities.read') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    action: "read all"
                }
            }).done(function(data){
                location.reload();
            });
        });
    
    </script>
@endpush