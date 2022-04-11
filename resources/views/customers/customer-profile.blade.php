@extends ('laraview.layouts.topNavLayout')

@section('title')
Profile
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $operator->company }}
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
        $active_link = '0';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <div class="card-body">
        @if ($customer->status == 'active')
        <h5 class="card-title text-success">Status: {{ $customer->status }}</h5>
        @else
        <h5 class="card-title text-danger">Status: {{ $customer->status }}</h5>
        @endif
    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item">Type: {{ $customer->connection_type }}</li>
        <li class="list-group-item">Mobile: {{ $customer->mobile }}</li>
        <li class="list-group-item">Active Package: {{ $customer->package_name }}</li>
        <li class="list-group-item">Package Started At: {{ $customer->package_started_at }}</li>
        <li class="list-group-item">Valid Untill: {{ $customer->package_expired_at }}</li>

        {{-- Only for Hotspot Customer --}}
        @if ($customer->connection_type == 'Hotspot')

        @if ($customer->rate_limit)
        <li class="list-group-item">Speed Limit: {{ $customer->rate_limit }} Mbps</li>
        @else
        <li class="list-group-item">Speed Limit: No Limit</li>
        @endif

        @if ($customer->total_octet_limit)
        <li class="list-group-item">Volume Limit: {{ $customer->total_octet_limit/1000000 }} MB</li>
        @else
        <li class="list-group-item">Volume Limit: Unlimited MB</li>
        @endif

        <li class="list-group-item">Volume Used:
            {{ ($customer->radaccts->sum('acctoutputoctets') +
            $customer->radaccts->sum('acctinputoctets') + $radaccts_history->sum('acctoutputoctets')
            + $radaccts_history->sum('acctinputoctets'))/1000/1000/1000 }}
            GB
        </li>

        @endif
        {{-- Only for Hotspot Customer --}}

    </ul>

    <div class="card-body">
        <a href="{{ route('customers.packages', ['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">Buy Package</a>
        <a href="{{ route('customers.radaccts', ['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">Internet History</a>
    </div>

</div>

@endsection

@section('pageJs')
@endsection
