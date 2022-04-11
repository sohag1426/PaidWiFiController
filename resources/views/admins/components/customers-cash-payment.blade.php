@section('contentTitle')
Cash Payment
@endsection

@section('content')

<div class="row">
    {{-- Left Column --}}
    <div class="col-sm-6">

        <div class="card">

            <form id="quickForm" method="POST"
                action="{{ route('customer_bills.cash-payments.store', ['customer_bill' => $customer_bill->id]) }}"
                onsubmit="return showWait()">

                <div class="card-body">

                    @csrf

                    <!--name-->
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer_bill->name }}" readonly>
                    </div>
                    <!--/name-->

                    <!--mobile-->
                    <div class="form-group">
                        <label for="mobile">Customer Mobile</label>
                        <input type="text" class="form-control" id="mobile" value="{{ $customer_bill->mobile }}"
                            readonly>
                    </div>
                    <!--/mobile-->

                    <!--billing_profile-->
                    <div class="form-group">
                        <label for="billing_profile">Billing Profile</label>
                        <input type="text" class="form-control" id="billing_profile"
                            value="{{ $billing_profile->name }}" readonly>
                    </div>
                    <!--/billing_profile-->

                    <!--total_due-->
                    <div class="form-group">
                        <label for="total_due">Total Due</label>
                        <input type="text" class="form-control" id="total_due" value="{{ $customer_bill->amount }}"
                            readonly>
                    </div>
                    <!--/total_due-->

                    <!--date-->
                    <div class='form-group'>
                        <label for='datepicker'><span class="text-danger">*</span>Date of Payment</label>
                        <input type='text' name='date' id='datepicker' class='form-control' value="{{ date('m/d/Y') }}"
                            required>
                    </div>
                    <!--/date-->

                    <!--amount_paid-->
                    @if (Auth::user()->can('editInvoice', $customer_bill))
                    <div class="form-group">

                        <label for="amount_paid"><span class="text-danger">*</span>Amount Paid</label>

                        <input name="amount_paid" type="text"
                            class="form-control @error('amount_paid') is-invalid @enderror" id="amount_paid"
                            value="{{ $customer_bill->amount }}" onpaste="return false;" ondrop="return false;"
                            autocomplete="off"
                            onblur="showRuntimeInvoice('{{ route('customer_bills.runtime-invoice.index', ['customer_bill' => $customer_bill->id]) }}')"
                            required>

                        @error('amount_paid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    @else
                    <div class="form-group">

                        <label for="amount_paid">Amount Paid</label>

                        <input type="text" class="form-control" id="amount_paid" value="{{ $customer_bill->amount }}"
                            disabled>

                    </div>
                    @endif
                    <!--/amount_paid-->

                    <!--discount-->
                    @can('discount', $customer_bill)
                    <div class="form-group">

                        <label for="discount">Discount/Bonus</label>

                        <input name="discount" type="text" class="form-control @error('discount') is-invalid @enderror"
                            id="discount" value="0" onpaste="return false;" ondrop="return false;" autocomplete="off"
                            onblur="showRuntimeInvoice('{{ route('customer_bills.runtime-invoice.index', ['customer_bill' => $customer_bill->id]) }}')">

                        @error('discount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    @endcan
                    <!--/discount-->

                    {{-- note --}}
                    <div class="form-group">

                        <label for="note">Note (optional)</label>

                        <input name="note" type="text" class="form-control" id="note">

                    </div>
                    {{-- note --}}

                    {{-- Do not bill operator --}}
                    @can('doNotBillOperator', $customer_bill)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="yes" id="dnb_operator"
                            name="dnb_operator">
                        <label class="form-check-label" for="dnb_operator">
                            Do not bill operator
                        </label>
                    </div>
                    @endcan
                    {{-- Do not bill operator --}}

                    {{-- confirmation sms --}}
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="yes" id="defaultCheck1"
                            name="require_sms_notice" checked>
                        <label class="form-check-label" for="defaultCheck1">
                            Send payment confirmation sms
                        </label>
                    </div>
                    {{-- confirmation sms --}}

                </div>
                <!--/card-body-->

                <div class="card-footer">
                    <button type="submit" id="btn-submit" class="btn btn-dark">SUBMIT</button>
                </div>
                <!--/card-footer-->
            </form>

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

                <dl>
                    {{-- Notes --}}
                    <dt><span class="text-danger">Notes</span></dt>
                    <dd>
                        <ul>
                            <li>
                                Amount Paid Greater than the Bill amount will not be added as advance payment.
                            </li>
                            <li>
                                To add advance payment use the Customers -> Action -> Advance Payment link
                            </li>
                            <li>
                                If the amount paid less than the bill amount, a new invoice will create for the due
                                amount.
                            </li>
                        </ul>
                    </dd>
                    {{-- Notes --}}
                </dl>

            </div>
        </div>
    </div>
    {{-- Right Column --}}
</div>

@endsection

@section('pageJs')

<script>
    $(function () {
        $('#datepicker').datepicker({
            autoclose: !0
        });
    });

    function showRuntimeInvoice(url)
    {
        $("#btn-submit").attr("disabled",true);
        $("#runtime_invoice").html('<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>');
        let amount = "{{ $customer_bill->amount }}";
        if ( $( "#amount_paid" ).length ) {
            amount =  $("#amount_paid").val();
        }
        let discount_amount = 0;
        if ( $( "#discount" ).length ) {
            discount_amount =  $("#discount").val();
        }
        let query = "?amount_paid=" + amount + "&discount=" + discount_amount;
        let get_url = url + query;
        $.get( get_url, function( data ) {
            $("#runtime_invoice").html(data);
            $("#btn-submit").attr("disabled",false);
        });
    }

</script>

@endsection
