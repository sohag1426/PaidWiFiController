@extends ('laraview.layouts.topNavLayout')

@section('title')
Send Money
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $operator->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
@include('customers.logout-nav')
@endsection

@section('content')

<div class="card">

    <div class="card-body text-center">

        <div class="card-header bg-info">
            Pay with {{ $payment_gateway->send_money_provider }}
        </div>

        <p class="card-text font-italic font-weight-bold">Package Name: {{ $package->name }}</p>

        <p class="card-text font-italic font-weight-bold">Amount: {{ $customer_payment->amount_paid }}
            {{ config('consumer.currency') }}
        </p>

        <p class="card-text">Customer: {{ $customer->mobile }}</p>

        @if ($package->rate_limit)
        <p class="card-text">Speed Limit: {{ $package->master_package->rate_limit }}
            {{ $package->master_package->readable_rate_unit }}</p>
        @else
        <p class="card-text">Speed Limit: Unlimited</p>
        @endif

        @if ($package->volume_limit)
        <p class="card-text">MB Limit: {{ $package->master_package->volume_limit }}
            {{ $package->master_package->volume_unit }}</p>
        @else
        <p class="card-text">MB Limit: Unlimited MB</p>
        @endif

        <p class="card-text">Validity: {{ $package->master_package->validity }} Days</p>

        <p class="card-text font-weight-bold">Payment Method: <i class="far fa-paper-plane text-danger"></i> Send Money
            ({{ $payment_gateway->send_money_provider }})</p>

        <p class="card-text font-weight-bold">
            {{ $payment_gateway->send_money_provider }} number: <i class="fas fa-mobile-alt text-danger"></i>
            {{ $payment_gateway->msisdn }} (personal)
        </p>

        <form method="POST"
            action="{{ route('send_money.customer_payment.store', ['customer_payment' => $customer_payment->id]) }}"
            onsubmit="return showWait()">

            @csrf

            <div class="form-row">

                <div class="form-group col-md-4">
                </div>

                {{-- card_number --}}
                <div class="form-group col-md-2">
                    <label for="card_number" class="sr-only">From Number</label>
                    <input type="text" class="form-control text-center" id="card_number" name="card_number"
                        placeholder="From Number" required>
                </div>
                {{-- card_number --}}

                {{-- bank_txnid --}}
                <div class="form-group col-md-2">
                    <label for="bank_txnid" class="sr-only">Transaction ID</label>
                    <input type="text" class="form-control text-center" id="bank_txnid" name="bank_txnid"
                        placeholder="Transaction ID" required>
                </div>
                {{-- bank_txnid --}}

                <div class="form-group col-md-4">
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
