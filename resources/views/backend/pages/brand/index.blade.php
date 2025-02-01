@extends('backend.app')
@section('page', 'Brands')
@section('content')
    <div class="row">
        @includeFirst(['backend.components.breadcrumb'])

        <div class="col-12 overview">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card bg-pink">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Brands</h5>
                            <p class="card-text text-white">{{ $brands->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-orange">
                        <div class="card-body">
                            <h5 class="card-title text-white">Active Brands</h5>
                            <p class="card-text text-white">{{ $brands->where('status', 'Active')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card bg-purple">
                        <div class="card-body">
                            <h5 class="card-title text-white">Inactive Brands</h5>
                            <p class="card-text text-white">{{ $brands->where('status', 'Inctive')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 d-flex justify-content-end mb-4">
            <div>
                <button onclick="loadModal('brand','create')" class="btn btn-primary" type="button">
                    <i class="fi fi-rr-add"></i>Add New Brand
                </button>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <form id="searchForm" action="" method="GET">
                    <div class="card-header">
                        <div class="row pb-3">



                            <div class="col-12 d-inline-flex align-items-center justify-content-between flex-wrap gap-3">

                                <div class="d-flex gap-2 order-0">
                                    <!--Filter-->
                                    <div>
                                        <button class="btn btn-outline-success" id="filterToggle" type="button">
                                            @if (request()->all())
                                                Clear Filter
                                            @else
                                                <i class="fi fi-rr-filter"></i>Filter
                                            @endif
                                        </button>
                                    </div>
                                    <!-- Search -->
                                    <div class="search-filter">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search" name="search"
                                                placeholder="Search here" value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="input-group-text">
                                                    <i class="fi fi-rr-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="filter"
                                    class="d-flex flex-grow-1 align-items-center justify-content-start gap-3 flex-wrap {{ request()->all() ? '' : 'd-none' }} order-2 order-md-1">

                                    <div>
                                        <select class="form-select" name="status">
                                            <option value="">Select Status</option>
                                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="Inactive"
                                                {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </form>
                <div class="card-body px-0">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive mb-3 overflow-y-hidden">
                                    <table class="table table-bordered table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 30px;">#</th>
                                                <th style="min-width: 30px;">Icon</th>
                                                <th style="min-width: 200px;">Name</th>
                                                <th style="min-width: 100px;">Status</th>
                                                <th style="min-width: 30px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $index => $item)
                                                <tr>
                                                    <td>{{ $items->firstItem() + $index }}</td>
                                                    <td>
                                                        <img class="table-contain-image" src="{{ asset($item->icon) }}">
                                                    </td>
                                                    <td>
                                                        {{ $item->name }}
                                                    </td>

                                                    <td>
                                                        <div
                                                            class="tag {{ $item->status == 'Active' ? 'tag-green' : 'tag-red' }}">
                                                            {{ $item->status }}
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="actions">
                                                            <button onclick="loadModal('brand','edit',{{ $item->id }})"
                                                                class="edit-btn action-btn">
                                                                <i class="fi fi-rr-edit"></i>
                                                            </button>
                                                            <button onclick="deleteItem({{ $item->id }},'brand')"
                                                                class="delete-btn action-btn">
                                                                <i class="fi fi-rr-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No data found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-xl-12 d-flex justify-content-end mt-3">
                        {{-- {{ $items->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
