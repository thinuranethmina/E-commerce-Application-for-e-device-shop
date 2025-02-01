@extends('backend.app')
@section('page', 'Notification Settings')
@section('content')
    @include('backend.components.breadcrumb')
    <div class="row top-row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">Email settings</h4>

                        <form class="required-form" action="{{ route('admin.notification_settings.email.update') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_notifications_enabled">Email
                                            notifications enabled?</label>
                                        <select class="form-select choices" name="email_notifications_enabled"
                                            id="email_notifications_enabled">
                                            <option value="" disabled selected>Select Option</option>
                                            <option value="1" @if ($settings['notification.email_notifications_enabled'] == '1') selected @endif>Yes
                                            </option>
                                            <option value="0" @if ($settings['notification.email_notifications_enabled'] == '0') selected @endif>No
                                            </option>
                                        </select>

                                        @if ($errors->has('email_notifications_enabled'))
                                            <div class="remind-msg">{{ $errors->first('email_notifications_enabled') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_sender_name">Email sender name</label>
                                        <input type="text" name="email_sender_name" id="email_sender_name"
                                            class="form-control"
                                            value="{{ old('email_sender_name', $settings['notification.email_sender_name'] ?? '') }}">

                                        @if ($errors->has('email_sender_name'))
                                            <div class="remind-msg">{{ $errors->first('email_sender_name') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_sender_address">Email sender address</label>
                                        <input type="email" name="email_sender_address" id="email_sender_address"
                                            class="form-control"
                                            value="{{ old('email_sender_address', $settings['notification.email_sender_address'] ?? '') }}">

                                        @if ($errors->has('email_sender_address'))
                                            <div class="remind-msg">{{ $errors->first('email_sender_address') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_smtp_server">Email smtp server</label>
                                        <input type="text" name="email_smtp_server" id="email_smtp_server"
                                            class="form-control"
                                            value="{{ old('email_smtp_server', $settings['notification.email_smtp_server'] ?? '') }}">

                                        @if ($errors->has('email_smtp_server'))
                                            <div class="remind-msg">{{ $errors->first('email_smtp_server') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_smtp_port">Email smtp port</label>
                                        <input type="text" name="email_smtp_port" id="email_smtp_port"
                                            class="form-control"
                                            value="{{ old('email_smtp_port', $settings['notification.email_smtp_port'] ?? '') }}">

                                        @if ($errors->has('email_smtp_port'))
                                            <div class="remind-msg">{{ $errors->first('email_smtp_port') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_smtp_username">Email smtp username</label>
                                        <input type="text" name="email_smtp_username" id="email_smtp_username"
                                            class="form-control"
                                            value="{{ old('email_smtp_username', $settings['notification.email_smtp_username'] ?? '') }}">

                                        @if ($errors->has('email_smtp_username'))
                                            <div class="remind-msg">{{ $errors->first('email_smtp_username') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_smtp_password">Email smtp password</label>
                                        <input type="password" name="email_smtp_password" id="email_smtp_password"
                                            class="form-control"
                                            value="{{ old('email_smtp_password', $settings['notification.email_smtp_password'] ?? '') }}">

                                        @if ($errors->has('email_smtp_password'))
                                            <div class="remind-msg">{{ $errors->first('email_smtp_password') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email_encryption">Email encryption</label>
                                        <select class="form-select choices" name="email_encryption" id="email_encryption">
                                            <option value="" disabled selected>Select Option</option>
                                            <option value="tls" @if ($settings['notification.email_encryption'] == 'tls') selected @endif>tls
                                            </option>
                                            <option value="ssl" @if ($settings['notification.email_encryption'] == 'ssl') selected @endif>ssl
                                            </option>
                                        </select>

                                        @if ($errors->has('email_encryption'))
                                            <div class="remind-msg">{{ $errors->first('email_encryption') }}</div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Email Settings</button>
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
