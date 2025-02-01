@extends('backend.app')
@section('page', 'Seasonal Banner')
@section('content')
    @include('backend.components.breadcrumb')
    <div class="row top-row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">Seasonal Banner</h4>

                        <form class="required-form" action="{{ route('admin.seasonal_banner.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-12 text-center">
                                    <div class="form-group d-inline-block">
                                        @php
                                            $data = [
                                                'width' => '400px',
                                                'height' => '250px',
                                                'maxHeight' => '250px',
                                                'name' => 'image',
                                                'cover' => false,
                                                'type' => 'box',
                                                'bgColor' => 'white',
                                                'src' => asset($banner->image),
                                            ];
                                        @endphp
                                        @include('backend.components.image-chooser', $data)
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="label1">Label 01</label>
                                        <input type="text" name="label1" id="label1" class="form-control"
                                            value="{{ old('label1', $banner->label1 ?? '') }}">

                                        @if ($errors->has('label1'))
                                            <div class="remind-msg">{{ $errors->first('label1') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="label2">Label 02</label>
                                        <input type="text" name="label2" id="label2" class="form-control"
                                            value="{{ old('label2', $banner->label2 ?? '') }}">

                                        @if ($errors->has('label2'))
                                            <div class="remind-msg">{{ $errors->first('label2') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="label3">Label 03</label>
                                        <input type="text" name="label3" id="label3" class="form-control"
                                            value="{{ old('label3', $banner->label3 ?? '') }}">

                                        @if ($errors->has('label3'))
                                            <div class="remind-msg">{{ $errors->first('label3') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="url">URL</label>
                                        <input type="text" name="url" id="url" class="form-control"
                                            value="{{ old('url', $banner->url ?? '') }}">

                                        @if ($errors->has('url'))
                                            <div class="remind-msg">{{ $errors->first('url') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="Active" @if ($banner->status == 'Active') selected @endif>Active
                                            </option>
                                            <option value="Inactive" @if ($banner->status == 'Inactive') selected @endif>
                                                Inactive
                                            </option>
                                        </select>

                                        @if ($errors->has('status'))
                                            <div class="remind-msg">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Seasonal Banner</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-5">

        </div>
    </div>
@endsection
