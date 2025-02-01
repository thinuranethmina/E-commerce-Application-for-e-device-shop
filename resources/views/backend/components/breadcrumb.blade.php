<div class="col-12">
    <div class="page-header">
        <h1 class="page-title my-auto">@yield('page')</h1>
        <div>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                @foreach (Request::segments() as $segment)
                    @if ($segment !== 'admin')
                        @php
                            $breadcrumb = ucfirst(str_replace('-', ' ', $segment));
                        @endphp
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
    </div>
</div>
