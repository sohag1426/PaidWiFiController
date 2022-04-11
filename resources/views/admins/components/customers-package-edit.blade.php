@section('contentTitle')
<h3> Edit customer Package </h3>
@endsection

@section('content')

<div class="row">

    {{-- Left Column --}}
    <div class="col-sm-6">

        <div class="card">

            <div class="card-body">

                <form method="POST"
                    action="{{ route('customer-package-change.update', ['customer' => $customer->id]) }}"
                    onsubmit="return showWait()">

                    @method('put')

                    @csrf

                    <!--name-->
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer->name }}" disabled>
                    </div>
                    <!--/name-->

                    <!--mobile-->
                    <div class="form-group">
                        <label for="mobile">Customer Mobile</label>
                        <input type="text" class="form-control" id="mobile" value="{{ $customer->mobile }}" disabled>
                    </div>
                    <!--/mobile-->

                    <!--Billing Profile-->
                    @if ($customer->connection_type !== 'Hotspot')
                    <div class="form-group">
                        <label for="billing_profile">Billing Profile</label>
                        <input type="text" class="form-control" id="billing_profile"
                            value="{{ $billing_profile->name }}" disabled>
                    </div>
                    @endif
                    <!--/Billing Profile-->

                    <!--Current Package & Validity -->
                    <div class="form-group">
                        <label for="package_validity">Current Package & Validity</label>
                        <input type="text" class="form-control" id="package_validity"
                            value="{{ $active_package->name }} | {{ $customer->package_expired_at }}" disabled>
                    </div>
                    <!--/Current Package & Validity -->

                    <!--package_id-->
                    <div class="form-group">
                        <label for="package_id"><span class="text-danger">*</span>Select Package</label>
                        <select class="form-control" id="package_id" name="package_id" required
                            onchange="showRuntimeInvoice('{{ $customer->id }}', '{{ $billing_profile->partial_payment }}')">
                            <option value="{{ $active_package->id }}" selected>{{ $active_package->name }}</option>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/package_id-->

                    @if ($customer->connection_type !== 'Hotspot' && $billing_profile->partial_payment == 'yes')

                    <!--validity-->
                    <div class="form-group">

                        <label for="validity"><span class="text-danger">*</span>Validity</label>

                        <div class="input-group">
                            <input name="validity" type="number" min="{{ $billing_profile->minimum_validity }}"
                                class="form-control @error('validity') is-invalid @enderror" id="validity"
                                value="{{ $billing_profile->minimum_validity }}"
                                onblur="showRuntimeInvoice('{{ $customer->id }}', '{{ $billing_profile->partial_payment }}')"
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

                    {{-- Submit Payment --}}
                    @if ($customer->connection_type !== 'Hotspot')
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="submit_payment" id="yes" value="yes" checked>
                        <label class="form-check-label" for="yes">
                            Submit Payment
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="submit_payment" id="no" value="no">
                        <label class="form-check-label" for="no">
                            Generate Bill
                        </label>
                    </div>
                    @endif
                    {{-- Submit Payment --}}

                    <button type="submit" id="btn-submit" class="btn btn-dark">SUBMIT</button>

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

@endsection

@section('pageJs')

<script>
    function showRuntimeInvoice(customer_id, partial_payment)
    {
        $("#btn-submit").attr("disabled",true);
        $("#runtime_invoice").html('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        let package = $("#package_id").val();
        let query = "?";
        if(partial_payment == "yes"){
            let validity = $("#validity").val();
            query = "?validity=" + validity;
        }
        let url = "/admin/package-change-runtime-invoice/" + customer_id + "/" + package;
        let get_url = url + query;
        $.get( get_url, function( data ) {
            $("#runtime_invoice").html(data);
            $("#btn-submit").attr("disabled",false);
        });
    }
</script>

@endsection
