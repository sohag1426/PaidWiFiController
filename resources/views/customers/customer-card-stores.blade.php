@extends ('laraview.layouts.topNavLayout')

@section('title')
Card Stores
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
        $active_link = '3';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}


    <div class="card-body">
        <table id="data_table" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Store Name</th>
                    <th scope="col">Store Address</th>
                    <th scope="col">Contact Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($card_distributors as $card_distributor)
                <tr>
                    <td>{{ $card_distributor->store_name }}</td>
                    <td>{{ $card_distributor->store_address }}</td>
                    <td>{{ $card_distributor->mobile }}</td>
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
