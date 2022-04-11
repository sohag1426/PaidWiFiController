@extends ('laraview.layouts.topNavLayout')

@section('title')
bKash Payment
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

    <div class="card-header text-center">
        <img src="/storage/logo/bKash_Payment_logo.png" alt="bKash Payment">
    </div>

    <div class="row">

        {{-- Invoice --}}
        <div class="col-sm-3">

            <div class="card-body">

                <h5><u>Invoice</u></h5>

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

            </div>

        </div>
        {{-- /Invoice --}}

        {{-- Method 1 --}}
        <div class="col-sm-5">

            <div class="card-body">

                <h5><u>Method 1# Dial *247#</u></h5>
                <p class="card-text">01. Go to your bKash Mobile Menu by dialing *247#</p>
                <p class="card-text">02. Choose “Payment”</p>
                <p class="card-text">03. Enter the Merchant bKash Account Number: {{ $payment_gateway->msisdn }}</p>
                <p class="card-text">04. Enter the amount : {{ $customer_payment->amount_paid }}</p>
                <p class="card-text">05. Enter a reference: 0</p>
                <p class="card-text">06. Enter the Counter Number: 0</p>
                <p class="card-text">07. Now enter your bKash Mobile Menu PIN to confirm</p>

            </div>

        </div>
        {{-- /Method 1 --}}

        {{-- Method 2 --}}
        <div class="col-sm-4">

            <div class="card-body">

                <h5><u>Method 2# Scan QR Code</u></h5>

                <img class="img-fluid" src="{{ $qr_code }}" alt="QR Code">

            </div>

        </div>
        {{-- / Method 2 --}}

    </div>

    <div class="row">

        <div class="col-sm">

            <div class="card-body text-center">

                <form method="POST"
                    action="{{ route('bkash_payment.customer_payment.store', ['customer_payment' => $customer_payment->id]) }}"
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

    </div>

</div>

@endsection

@section('pageJs')
@endsection
