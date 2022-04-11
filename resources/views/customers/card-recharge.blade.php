@extends ('laraview.layouts.topNavLayout')

@section('title')
Card Recharge
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
        $active_link = '8';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <div class="card-body">
                <form id="quickForm" method="POST"
                    action="{{ route('card-recharge.store', ['mobile' => $customer->mobile]) }}"
                    onsubmit="return showWait()">
                    @csrf
                    <!--card_pin-->
                    <div class="form-group">
                        <label for="card_pin"><span class="text-danger">*</span>Card PIN</label>
                        <input name="card_pin" type="text" class="form-control @error('card_pin') is-invalid @enderror"
                            id="card_pin" value="{{ old('card_pin') }}" required>
                        @error('card_pin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/card_pin-->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
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
