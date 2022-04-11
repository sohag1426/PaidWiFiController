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
<h4> Edit Speed Limit for the customer: {{ $customer->mobile }} </h4>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form id="quickForm" method="POST"
            action="{{ route('customer-package-speed-limit.update', ['customer' => $customer->id]) }}">


            <div class="row">

                <div class="col-sm-6">

                    @csrf
                    @method('put')

                    <!--rate_limit-->
                    <div class="form-group">
                        <label for="rate_limit"><span class="text-danger">*</span>Speed Limit</label>

                        <div class="input-group">
                            <input name="rate_limit" type="text"
                                class="form-control @error('rate_limit') is-invalid @enderror" id="rate_limit"
                                aria-describedby="rateLimitHelp" value="{{ $customer->rate_limit }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Mbps</span>
                            </div>
                        </div>

                        <small id="rateLimitHelp" class="form-text text-muted">Please Enter 0(zero) to manage from
                            router.</small>

                        @error('rate_limit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <!--/rate_limit-->

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
