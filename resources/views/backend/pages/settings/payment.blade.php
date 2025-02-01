@extends('backend.app')
@section('page', 'System Settings')
@section('content')
    @include('backend.components.breadcrumb')
    <div class="row top-row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">PayHere settings</h4>

                        <form class="required-form" action="{{ route('admin.payment_settings.payment_gateway.update') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="form-label" for="payhere_merchant_id">PayHere Merchant ID</label>
                                <input type="text" name="payhere_merchant_id" id="payhere_merchant_id"
                                    class="form-control"
                                    value="{{ old('payhere_merchant_id', $settings['payment.payhere_merchant_id'] ?? '') }}">

                                @if ($errors->has('payhere_merchant_id'))
                                    <div class="remind-msg">{{ $errors->first('payhere_merchant_id') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="payhere_secret_key">PayHere Secret Key</label>
                                <input type="text" name="payhere_secret_key" id="payhere_secret_key" class="form-control"
                                    value="{{ old('payhere_secret_key', $settings['payment.payhere_secret_key'] ?? '') }}">

                                @if ($errors->has('payhere_secret_key'))
                                    <div class="remind-msg">{{ $errors->first('payhere_secret_key') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="refund_policy">Refund policy</label>
                                <input type="text" name="refund_policy" id="refund_policy" class="form-control"
                                    value="{{ old('refund_policy', $settings['payment.refund_policy'] ?? '') }}">

                                @if ($errors->has('refund_policy'))
                                    <div class="remind-msg" aria->{{ $errors->first('refund_policy') }}</div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update PayHere Settings</button>
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
                        <h4 class="mb-3 header-title">Offline payment settings</h4>

                        <form class="required-form" action="{{ route('admin.payment_settings.offline.update') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="form-label" for="bank_info">Bank Information</label>

                                <input type="text" class="form-control mb-3" name="bank_name" id="bank_name"
                                    placeholder="Bank Name"
                                    value="{{ old('bank_name', $settings['payment.bank_name'] ?? '') }}">

                                <textarea class="form-control" name="bank_info" id="bank_info" cols="30" rows="5" placeholder="">{{ old('bank_info', $settings['payment.bank_info'] ?? '') }}</textarea>

                                @if ($errors->has('bank_info'))
                                    <div class="remind-msg">{{ $errors->first('bank_info') }}</div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Offline Payment</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="mb-3 header-title">Delivery Fee</h4>

                        <form class="required-form" action="{{ route('admin.payment_settings.delivery.update') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="form-label" for="delivery_fee">Delivery Fee</label>

                                <input type="text" class="form-control mb-3" name="delivery_fee" id="delivery_fee"
                                    placeholder="Delivery Fee"
                                    value="{{ old('delivery_fee', $settings['payment.delivery_fee'] ?? '') }}">

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Delivery Fee</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
