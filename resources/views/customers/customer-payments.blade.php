@extends ('laraview.layouts.topNavLayout')

@section('title')
Payments
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
        $active_link = '5';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <div class="card-body">

        <table id="data_table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">TxnID/PIN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->date }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->pay_status }}</td>
                    <td>{{ $payment->bank_txnid }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

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
