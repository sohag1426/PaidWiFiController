@extends ('laraview.layouts.sideNavLayout')

@section('title')
Edit Speed Limit
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '5';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')
<h4> Edit Volume Limit for the customer: {{ $customer->mobile }} </h4>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form id="quickForm" method="POST"
            action="{{ route('customer-package-volume-limit.update', ['customer' => $customer->id]) }}">


            <div class="row">

                <div class="col-sm-6">

                    @csrf
                    @method('put')

                    <!--volume_limit-->
                    <div class="form-group">
                        <label for="volume_limit"><span class="text-danger">*</span>Volume Limit</label>

                        <div class="input-group">
                            <input name="volume_limit" type="text"
                                class="form-control @error('volume_limit') is-invalid @enderror" id="volume_limit"
                                aria-describedby="mbLimitHelp" value="{{ $customer->total_octet_limit/1000/1000/1000 }}"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    GB
                                </span>
                            </div>
                        </div>

                        <small id="mbLimitHelp" class="form-text text-muted">Please Enter 0(zero) for unlimited
                            volume.</small>

                        @error('volume_limit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <!--/volume_limit-->

                    <button type="submit" class="btn btn-dark">SUBMIT</button>

                </div>
                <!--/col-sm-6-->

            </div>
            <!--/row-->

        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
