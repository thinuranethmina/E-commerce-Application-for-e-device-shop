@extends('backend.app')
@section('page', 'System Settings')
@section('content')
    @include('backend.components.breadcrumb')
    <div class="row top-row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">System settings</h4>

                        <form class="ajaxForm" action="{{ route('admin.system_settings.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="site_name">Website name<span
                                        class="required">*</span></label>
                                <input type="text" name="site_name" id="site_name" class="form-control"
                                    value="{{ $settings['website.site_name'] }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="meta_title">Website title<span
                                        class="required">*</span></label>
                                <input type="text" name="meta_title" id="meta_title" class="form-control"
                                    value="{{ $settings['website.meta_title'] }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="meta_keywords">Website keywords</label>
                                <input type="text" class="form-control bootstrap-tag-input" id="meta_keywords"
                                    name="meta_keywords" data-role="tagsinput"
                                    value="{{ $settings['website.meta_keywords'] }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="meta_description">Website description</label>
                                <textarea name="meta_description" id="meta_description" class="form-control" rows="5">{{ $settings['website.meta_description'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="site_light_logo">Website Light Logo</label>

                                @php
                                    $data = [
                                        'width' => '250px',
                                        'height' => 'auto',
                                        'maxHeight' => '80px',
                                        'name' => 'site_light_logo',
                                        'cover' => false,
                                        'type' => 'box',
                                        'bgColor' => 'white',
                                        'src' => asset(
                                            'assets/global/images/logos/' . $settings['website.site_light_logo'],
                                        ),
                                    ];
                                @endphp

                                @include('backend.components.image-chooser', $data)

                            </div>

                            <div class="form-group">
                                <label class="form-label" for="site_dark_logo">Website Dark Logo</label>

                                @php
                                    $data = [
                                        'width' => '250px',
                                        'height' => 'auto',
                                        'maxHeight' => '80px',
                                        'name' => 'site_dark_logo',
                                        'cover' => false,
                                        'type' => 'box',
                                        'bgColor' => 'black',
                                        'src' => asset(
                                            'assets/global/images/logos/' . $settings['website.site_dark_logo'],
                                        ),
                                    ];
                                @endphp

                                @include('backend.components.image-chooser', $data)

                            </div>

                            <div class="form-group">
                                <label class="form-label" for="site_favicon">Website Favicon</label>
                                @php
                                    $data = [
                                        'width' => 'auto',
                                        'height' => 'auto',
                                        'maxHeight' => '80px',
                                        'name' => 'site_favicon',
                                        'cover' => false,
                                        'type' => 'box',
                                        'bgColor' => 'black',
                                        'src' => asset(
                                            'assets/global/images/favicon/' . $settings['website.site_favicon'],
                                        ),
                                    ];
                                @endphp

                                @include('backend.components.image-chooser', $data)

                            </div>

                            <div class="form-group">
                                <label class="form-label" for="google_analytics_code">Google analytics id</label>
                                <input type="text" name="google_analytics_code" id="google_analytics_code"
                                    class="form-control" value="{{ $settings['website.google_analytics_code'] ?? '' }}">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Settings</button>
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
                        <h4 class="mb-3 header-title">Update product <small>(Comming soon)</small></h4>

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-2">
                                <label class="form-label">File</label>
                                <div class="input-group">
                                    <div class="w-100 custom-file">
                                        <input type="file" class="w-100 form-control" id="file_name" name="file_name"
                                            required="" onchange="changeTitleOfImageUploader(this)">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary"
                                    style="cursor: not-allowed !important;">Update System</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
