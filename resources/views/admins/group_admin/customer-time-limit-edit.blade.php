@extends ('laraview.layouts.sideNavLayout')

@section('title')
Edit Time Limit
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
<h4> Edit Time Limit for the customer: {{ $customer->mobile }} </h4>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form id="quickForm" method="POST"
            action="{{ route('customer-package-time-limit.update', ['customer' => $customer->id]) }}">


            <div class="row">

                <div class="col-sm-6">

                    @csrf
                    @method('put')

                    <!--validity-->
                    <div class="form-group">
                        <label for="validity"><span class="text-danger">*</span>Extend</label>

                        <div class="input-group">
                            <input name="validity" type="text"
                                class="form-control @error('validity') is-invalid @enderror" id="validity"
                                value="{{ old('validity') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Days</span>
                            </div>
                        </div>

                        @error('validity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <!--/validity-->

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
