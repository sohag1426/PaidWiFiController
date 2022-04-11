@extends ('laraview.layouts.topNavLayout')

@section('title')
Buy Package
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

    <!-- Modal Instruction-->
    <div class="modal fade" id="ModalInstruction" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="overlay-wrapper">
                        <p>Please Open the Link in a Browser <i class="fab fa-chrome"></i></p>
                        @if (config('consumer.currency') == "BDT")
                        <p>(লিংকটি কপি করে মোবাইলের ব্রাউজার এ ওপেন করুন)</p>
                        @endif
                        <!--input-group -->
                        <div class="input-group input-group-sm">
                            <input type="text" id="LinkLogin" value="{{ route('root') }}" class="form-control">
                            <span class="input-group-append">
                                <button onclick="copyToClipboard()" type="button" class="btn btn-info btn-flat">
                                    <span id="LinkLoginCopy">Copy to clipboard</span>
                                </button>
                            </span>
                        </div>
                        <!--/input-group -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/modal Instruction-->

    {{-- Navigation bar --}}
    <div class="card-header">
        @php
        $active_link = '1';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <nav class="navbar navbar-light bg-light justify-content-end">

        <form class="form-inline" method="GET"
            action="{{ route('customers.packages',['mobile' => $customer->mobile]) }}" onsubmit="return showWait()">

            {{-- sort --}}
            <div class="form-group mr-sm-2">
                <select name="sort" id="sort" class="form-control">
                    <option value=''>sort by...</option>
                    <option value='price'>price</option>
                    <option value='validity'>validity</option>
                </select>
            </div>
            {{--sort --}}

            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">FILTER</button>

        </form>

    </nav>

    <div class="row">

        @foreach ( $packages as $package )

        <div class="col-sm-4">

            <div class="position-relative p-3 border border-secondary">

                <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon bg-danger">
                        Price: {{ $package->price }} {{ config('consumer.currency') }}
                    </div>
                </div>

                <ul class="list-group list-group-flush">

                    <button type="button" class="list-group-item list-group-item-action active">
                        {{ $package->name }}
                    </button>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Speed Limit
                        @if ($package->rate_limit)
                        <span class="badge badge-primary badge-pill">{{ $package->master_package->rate_limit }}
                            {{ $package->master_package->readable_rate_unit }}</span>
                        @else
                        <span class="badge badge-primary badge-pill">Unlimited</span>
                        @endif
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Volume Limit
                        @if ($package->master_package->volume_limit)
                        <span class="badge badge-primary badge-pill">{{ $package->master_package->volume_limit }}
                            {{ $package->volume_unit }}</span>
                        @else
                        <span class="badge badge-primary badge-pill">Unlimited MB</span>
                        @endif
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Validity
                        <span class="badge badge-primary badge-pill">{{ $package->master_package->validity }} Days
                        </span>
                    </li>

                    @if ($package->fair_usage_policy)
                    <li class="list-group-item">
                        Note: If the data usage exceeds <span class="font-weight-bold">
                            {{ $package->fair_usage_policy->data_limit }} GB </span>,
                        the speed limit will drop to <span class="font-weight-bold">
                            {{ $package->fair_usage_policy->speed_limit }} Mbps </span>
                    </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <form class="form-inline" method="get"
                            action="{{ route('customers.purchase-package', ['mobile' => $customer->mobile, 'package' => $package->id]) }}"
                            onsubmit="return checkWebView()">

                            <div class="form-group">

                                <label for="payment_gateway_id" class="sr-only">Payment Gateway</label>

                                <select id="payment_gateway_id" name="payment_gateway_id"
                                    class="form-control form-control-sm" required>
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

                            <button type="submit" class="btn btn-danger btn-sm">BUY</button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

        @endforeach

    </div>

    <div class="card-body">
        <a href="{{ route('customers.profile',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">Profile</a>
        <a href="{{ route('customers.radaccts',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">Internet History</a>
    </div>

</div>

@endsection

@section('pageJs')
<script>
    function checkWebView(){

        let gateway_id = $("#payment_gateway_id").val();

        if(parseInt(gateway_id) !== 0){

            let userAgentString = navigator.userAgent;

            if (userAgentString.indexOf('wv') > -1) {

                $('#ModalInstruction').modal({
                    backdrop: 'static',
                    // show: true
                });

                // return false;
            }
        }

        $('#ModalShowWait').modal({
            backdrop: 'static',
            show: true
        });

        return true;
    }

    function copyToClipboard() {
      var copyText = document.getElementById("LinkLogin");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");

      var tooltip = document.getElementById("LinkLoginCopy");
      tooltip.innerHTML = "Copied";
    }
</script>
@endsection
