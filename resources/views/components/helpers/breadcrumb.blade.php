<!-- Breadcrumb -->
<div class="content">
    <nav class="breadcrumb push rounded-pill p-0 mb-0">
        <a class="breadcrumb-item" href="/">Home</a>
        @foreach($segments as $segment)
            <a class="breadcrumb-item" href="{{ $segment->url() }}">{{ optional($segment->model())->title ?: $segment->name() }}</a>
        @endforeach
    </nav>
</div>
