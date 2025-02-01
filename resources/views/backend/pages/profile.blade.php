@extends('backend.app')
@section('page', 'My Profile')
@section('content')
    @include('backend.components.breadcrumb')
    <div class="row top-row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">My Profile</h4>

                        <form class="required-form" action="{{ route('admin.profile.update', Auth::user()->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="lname">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', $data->name) }}">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email *</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            value="{{ old('email', $data->email) }}">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone">Phone *</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ old('phone', $data->phone) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update Bio Details</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">Privacy settings</h4>

                        <form class="required-form" action="{{ route('admin.profile.changePassword') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="new_password">New Password</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="new_password_confirmation">Confirm Password</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
