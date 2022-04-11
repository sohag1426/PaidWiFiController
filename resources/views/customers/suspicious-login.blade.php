@extends('laraview.layouts.topNavLayout')

@section('title')
Suspicious Login
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="alert alert-light" role="alert">
            <h4 class="alert-heading">Alert!</h4>
            <p>Needs to verify it's you</p>
            <hr>
            <p>A verification code will send to {{ $customer->mobile }}</p>
            <hr>
            <a href="{{ route('customer.replace.mac', ['mobile' => $customer->mobile]) }}" class="btn btn-primary mt-4"
                onclick="showWait()">
                Send Verification Code
            </a>

        </div>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
