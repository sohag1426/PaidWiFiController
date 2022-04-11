@extends ('laraview.layouts.topNavLayout')

@section('title')
Bills
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
        $active_link = '4';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    @foreach ($bills as $bill)

    <ul class="list-group list-group-flush">
        <li class="list-group-item">Username: {{ $bill->username }}</li>
        <li class="list-group-item">Mobile: {{ $bill->mobile }}</li>
        <li class="list-group-item">Amount: {{ $bill->amount }}</li>
        <li class="list-group-item">Description: {{ $bill->description }}</li>
        <li class="list-group-item">Billing Period: {{ $bill->billing_period }}</li>
        <li class="list-group-item">Due Date: {{ $bill->due_date }}</li>
        <li class="list-group-item">

            <form class="form-inline" method="get"
                action="{{ route('customers.pay-bill', ['mobile' => $customer->mobile, 'customer_bill' => $bill->id ]) }}"
                onsubmit="return showWait()">

                <div class="form-group">

                    <label for="payment_gateway_id" class="sr-only">Payment Gateway</label>

                    <select id="payment_gateway_id" name="payment_gateway_id" class="form-control form-control-sm"
                        required>

                        <option value="">Pay With...</option>

                        @if ($recharge_card_gw)
                        <option value="{{ $recharge_card_gw->id }}">
                            {{ $recharge_card_gw->payment_method }}
                        </option>
                        @endif

                        @if ($payment_gateways)

                        @foreach ($payment_gateways as $payment_gateway)

                        <option value="{{ $payment_gateway->id }}">
                            {{ $payment_gateway->payment_method }}
                        </option>

                        @endforeach

                        @endif

                    </select>

                </div>

                <button type="submit" class="btn btn-danger btn-sm">PAY</button>

            </form>


        </li>
    </ul>

    @endforeach

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
