@extends ('laraview.layouts.topNavLayout')

@section('title')
Complaint Details
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
{{-- Logout Button --}}
@include('customers.logout-nav')
{{-- Logout Button --}}
@endsection

@section('content')

<div class="card">

    {{-- Navigation bar --}}
    <div class="card-header">
        @php
        $active_link = '6';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <div class="card-body">

        @include('complaint_management.complaint-timeline')

    </div>

    <div class="card-body">
        <a href="{{ route('customers.packages',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">
            Buy Package
        </a>
        <a href="{{ route('customers.profile',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">
            Profile
        </a>
    </div>

</div>

@endsection

@section('pageJs')
@endsection
