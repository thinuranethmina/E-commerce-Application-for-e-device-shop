@extends('backend.app')
@section('page', 'Stock')
@section('content')
    <div class="row">
        @includeFirst(['backend.components.breadcrumb'])

        <div class="col-xl-12 d-flex justify-content-end mb-4">
            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary" type="button">
                    <i class="fi fi-rr-add"></i>Add New Product
                </a>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <form id="searchForm" action="" method="GET">
                    <div class="card-header">
                        <div class="row pb-3">
                            <div class="col-12 d-inline-flex align-items-center justify-content-between flex-wrap gap-3">

                                <div class="d-flex gap-2">
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
                                                <th style="min-width: 30px;">Image</th>
                                                <th style="min-width: 200px;">Name</th>
                                                <th style="min-width: 200px;">Stock</th>
                                                <th style="min-width: 100px;">Price</th>
                                                <th style="min-width: 30px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td>{{ $items->firstItem() + $index }}</td>
                                                    <td>
                                                        <img class="rounded-circle avatar-xs avatar"
                                                            src="{{ asset($item->product->thumbnail) }}">
                                                    </td>
                                                    <td>
                                                        {{ $item->product->name }}
                                                        @if ($item->values->count() > 0)
                                                            (@foreach ($item->values as $type)
                                                                {{ $type->variationValue->variable }}
                                                                @if (!$loop->last)
                                                                    |
                                                                @endif
                                                            @endforeach)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->stock }}
                                                    </td>
                                                    <td>
                                                        LKR {{ number_format($item->price, 2) }}
                                                    </td>
                                                    <td>
                                                        <div class="actions">
                                                            <a target="_blank"
                                                                href="{{ route('admin.products.edit', $item->product->id) }}"
                                                                class="edit-btn action-btn">
                                                                <i class="fi fi-rr-edit"></i>
                                                            </a>
                                                        </div>
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
                        {{-- {{ $items->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
