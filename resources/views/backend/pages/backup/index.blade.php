@extends('backend.app')
@section('page', 'Backups')
@section('content')
    <div class="row">
        @includeFirst(['backend.components.breadcrumb'])


        <div class="col-xl-12 d-flex justify-content-end mb-4">
            <div>
                <form action="{{ route('admin.backup.create') }}" method="GET">
                    <button class="btn btn-primary" type="submit">
                        <i class="fi fi-rr-add"></i>Create New Backup
                    </button>
                </form>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <form id="searchForm" action="{{ route('admin.backup.index') }}" method="GET">
                    <div class="card-header">
                        <div class="row pb-3">
                            <div class="col-xl-3">
                                <h4 class="mb-3 header-title">Database Backups</h4>
                            </div>

                            <div class="col-lg-9 d-inline-flex align-items-center justify-content-end gap-3">

                                <div class="search-filter">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search"
                                            placeholder="Search" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24" class="search-icon">
                                                    <path fill="currentColor"
                                                        d="m22.241 24l-7.414-7.414a9.5 9.5 0 0 1-5.652 1.885h-.002l-.108.001A9.065 9.065 0 0 1 0 9.407l.001-.114v.006a9.298 9.298 0 0 1 18.596 0a9.8 9.8 0 0 1-1.904 5.682l.019-.027l7.414 7.414zM9.299 2.513a6.758 6.758 0 1 0 .029.001zH9.3z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
                <div class="card-body px-0">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive mb-3 overflow-y-hidden">
                                    <table class="table table-hover table-bordered table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Created At</th>
                                                <th width="150"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($backups as $index => $item)
                                                <tr>
                                                    <td>{{ $backups->firstItem() + $index }}</td>
                                                    <td>{{ $item->file_name }}</td>
                                                    <td>{{ $item->created_at->format('Y-m-d h:i A') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.backup.download', $item->id) }}"
                                                            method="GET">
                                                            <div class="dropdown">
                                                                <button class="btn action-btn dropdown-toggle"
                                                                    type="submit">
                                                                    Download
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-xl-12 d-flex justify-content-end mt-3">
                        {{ $backups->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
