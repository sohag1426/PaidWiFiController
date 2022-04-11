@extends ('laraview.layouts.topNavLayout')

@section('title')
Home
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

    <div class="card-body">

        {{-- Card Recharge --}}
        <a class="btn btn-app bg-maroon" href="{{ route('card-recharge.create', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="far fa-credit-card"></i>
            <h6> Card Recharge </h6>
        </a>
        {{-- Card Recharge --}}

        {{-- Profile --}}
        <a class="btn btn-app bg-info" href="{{ route('customers.profile', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-user"></i>
            <h6> Profile </h6>
        </a>
        {{-- Profile --}}

        {{-- Card Stores --}}
        <a class="btn btn-app bg-orange" href="{{ route('customers.card-stores', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-store"></i>
            <h6> Card Stores </h6>
        </a>
        {{-- Card Stores --}}

        {{-- Buy Package --}}
        <a class="btn btn-app bg-success" href="{{ route('customers.packages', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-store"></i>
            <h6> Buy Package </h6>
        </a>
        {{-- Buy Package --}}

        {{-- Internet History --}}
        <a class="btn btn-app bg-navy" href="{{ route('customers.radaccts', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-history"></i>
            <h6> Internet History </h6>
        </a>
        {{-- Internet History --}}

        {{-- Bandwidth Graph --}}
        <a class="btn btn-app bg-lightblue" href="{{ route('customers.graph', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-chart-bar"></i>
            <h6> Bandwidth Graph </h6>
        </a>
        {{-- Bandwidth Graph --}}

        {{-- Bills --}}
        @if ($customer->connection_type !== 'Hotspot')
        <a class="btn btn-app bg-purple" href="{{ route('customers.bills', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-file-invoice-dollar"></i>
            <h6> Bills </h6>
        </a>
        @endif
        {{-- Bills --}}

        {{-- Payment History --}}
        <a class="btn btn-app bg-olive" href="{{ route('customers.payments', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-history"></i>
            <h6> Payment History </h6>
        </a>
        {{-- Payment History --}}

        {{-- Complaints --}}
        <a class="btn btn-app bg-teal"
            href="{{ route('complaints-customer-interface.index', ['mobile' => $customer->mobile]) }}"
            onclick="showWait()">
            <i class="fas fa-mail-bulk"></i>
            <h6> Complaints </h6>
        </a>
        {{-- Complaints --}}

    </div>

</div>

@endsection

@section('pageJs')
@endsection
