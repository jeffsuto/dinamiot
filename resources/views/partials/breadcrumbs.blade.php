<div class="content-header row">
    <div class="content-header-left col-md-6 col-xs-12 mb-1">
        <h2 class="content-header-title white">
            {{ $breadcrumbs[count($breadcrumbs)-1]->title }}
        </h2>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
        <div class="breadcrumb-wrapper col-xs-12">
            @if (count($breadcrumbs))

                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)

                        @if ($breadcrumb->url && !$loop->last)
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb->url }}" class="blue">{{ $breadcrumb->title }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active white">{{ $breadcrumb->title }}</li>
                        @endif

                    @endforeach
                </ol>

            @endif
        </div>
    </div>
</div>