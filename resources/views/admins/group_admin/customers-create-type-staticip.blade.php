@extends ('laraview.layouts.sideNavLayout')

@section('title')
New customer
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '5';
$active_link = '0';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')
<h3> Router </h3>
@endsection

@section('content')

<div class="card">

    <div class="row">
        {{-- Left Column --}}
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">

                    <form method="POST"
                        action="{{ route('temp_customers.staticip.store', ['temp_customer' => $temp_customer->id]) }}"
                        onsubmit="return showWait()">

                        @csrf

                        <!--router_id-->
                        <div class="form-group">
                            <label for="router_id"><span class="text-danger">*</span>Router</label>

                            <select class="form-control" id="router_id" name="router_id" required>

                                @foreach ($routers as $router)
                                <option value="{{ $router->id }}">{{ $router->location }} :: {{ $router->nasname }}
                                </option>
                                @endforeach

                            </select>

                            @error('router_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!--/router_id-->

                        <!--login_ip-->
                        <div class="form-group">
                            <label for="login_ip"><span class="text-danger">*</span>IP Address</label>
                            <input name="login_ip" type="text"
                                class="form-control @error('login_ip') is-invalid @enderror" id="login_ip"
                                value="{{ old('login_ip') }}" required>

                            @error('login_ip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <!--/login_ip-->

                        @if ($billing_profile->partial_payment == 'yes')

                        <!--validity-->
                        <div class="form-group">

                            <label for="validity"><span class="text-danger">*</span>Validity</label>

                            <div class="input-group">
                                <input name="validity" type="number" min="{{ $billing_profile->minimum_validity }}"
                                    class="form-control @error('validity') is-invalid @enderror" id="validity"
                                    value="{{ $billing_profile->minimum_validity }}"
                                    onblur="showRuntimeInvoice('{{ route('temp_customers.runtime-invoice.index', ['temp_customer' => $temp_customer->id]) }}')"
                                    aria-describedby="validityHelpBlock" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">Days</span>
                                </div>
                            </div>

                            <small id="validityHelpBlock" class="form-text text-muted">
                                Minimum Required Validity : {{ $billing_profile->minimum_validity }} Days
                            </small>

                            @error('validity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <!--/validity-->

                        @endif

                        <button type="submit" id="btn-submit" class="btn btn-dark">NEXT<i
                                class="fas fa-arrow-right"></i></button>

                    </form>

                </div>
            </div>
        </div>
        {{-- Left Column --}}
        {{-- Right Column --}}
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <p>Generated Bill/Invoice</p>

                    <div id="runtime_invoice">

                        @include('admins.components.runtime-invoice')

                    </div>
                </div>
            </div>
        </div>
        {{-- Right Column --}}
    </div>

</div>

@endsection

@section('pageJs')

<script>
    function showRuntimeInvoice(url)
    {
        $("#btn-submit").attr("disabled",true);
        $("#runtime_invoice").html('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        let validity = $("#validity").val();
        let query = "?validity=" + validity;
        let get_url = url + query;
        $.get( get_url, function( data ) {
            $("#runtime_invoice").html(data);
            $("#btn-submit").attr("disabled",false);
        });
    }
</script>

@endsection
