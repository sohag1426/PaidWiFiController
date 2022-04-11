@section('contentTitle')
<h3> PPP Customer's username and password. </h3>
@endsection

@section('content')

<div class="row">

    {{-- Left Column --}}
    <div class="col-sm-6">

        <div class="card">

            <div class="card-body">

                <form method="POST"
                    action="{{ route('temp_customers.pppoe.store', ['temp_customer' => $temp_customer->id]) }}"
                    onsubmit="return showWait()">

                    @csrf

                    <!--username-->
                    <div class="form-group">
                        <label for="username"><span class="text-danger">*</span>username</label>
                        <input name="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            id="username" value="{{ old('username') }}" autocomplete="off"
                            onblur="checkDuplicateUsername(this.value)" required>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div id="duplicate_username_response"></div>

                    </div>
                    <!--/username-->

                    <!--password-->
                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span>password</label>
                        <input name="password" type="text" class="form-control @error('password') is-invalid @enderror"
                            id="password" value="{{ old('password') }}" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/password-->

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

                    {{-- sms_password --}}
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="yes" id="defaultCheck1"
                            name="sms_password" checked>
                        <label class="form-check-label" for="defaultCheck1">
                            Send username and password to customer's mobile.
                        </label>
                    </div>
                    {{-- sms_password --}}

                    <button type="submit" class="btn btn-dark" id="btn-submit">NEXT<i
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

@endsection

@section('pageJs')

<script>
    function checkDuplicateUsername(username)
    {
        let url = "/admin/check-customers-uniqueness?attribute=username&value=" + username;
        $.get( url, function( data ) {
            $("#duplicate_username_response").html(data);
        });
    }

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
