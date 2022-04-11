@php

$links = [
'0' => 0,
'1' => 0,
'2' => 0,
'3' => 0,
'4' => 0,
'5' => 0,
'6' => 0,
'7' => 0,
'8' => 0,
'9' => 0,
'10' => 0,
];

if(isset($active_link)){
$links[$active_link] = 1;
}

@endphp

<ul class="nav nav-pills card-header-pills">
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('customers.home', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['9']) active @endif" onclick="showWait()">
            <i class="fas fa-home"></i>
            Home
        </a>
    </li>
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('card-recharge.create', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['8']) active @endif" onclick="showWait()">
            <i class="far fa-credit-card"></i>
            Card Recharge
        </a>
    </li>
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('customers.profile', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['0']) active @endif" onclick="showWait()">
            <i class="fas fa-user"></i>
            Profile
        </a>
    </li>
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('customers.packages', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['1']) active @endif" onclick="showWait()">
            <i class="fas fa-store"></i>
            Buy Package
        </a>
    </li>
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('customers.radaccts', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['2']) active @endif" onclick="showWait()">
            <i class="fas fa-history"></i>
            Internet History
        </a>
    </li>
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('customers.graph', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['7']) active @endif" onclick="showWait()">
            <i class="fas fa-chart-bar"></i>
            Bandwidth Graph
        </a>
    </li>
    {{--  --}}
    <a href="{{ route('customers.card-stores', ['mobile' => $customer->mobile]) }}"
        class="nav-link @if ($links['3']) active @endif" onclick="showWait()">
        <i class="fas fa-store"></i>
        Card Stores
    </a>
    {{--  --}}
    @if ($customer->connection_type !== 'Hotspot')
    <li class="nav-item">
        <a href="{{ route('customers.bills', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['4']) active @endif" onclick="showWait()">
            <i class="fas fa-file-invoice-dollar"></i>
            Bills
        </a>
    </li>
    @endif
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('customers.payments', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['5']) active @endif" onclick="showWait()">
            <i class="fas fa-history"></i>
            Payment History
        </a>
    </li>
    {{--  --}}
    <li class="nav-item">
        <a href="{{ route('complaints-customer-interface.index', ['mobile' => $customer->mobile]) }}"
            class="nav-link @if ($links['6']) active @endif" onclick="showWait()">
            <i class="fas fa-mail-bulk"></i>
            Complaints
        </a>
    </li>
    {{--  --}}

</ul>
