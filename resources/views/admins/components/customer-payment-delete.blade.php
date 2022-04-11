@section('contentTitle')
<h3>Delete Customer's Payment</h3>
<div class="alert alert-dark" role="alert">
    Only accounting will be effected. Customers validity will not be effected.
</div>
<div class="alert alert-dark" role="alert">
    A new adjustment payment will be created.
</div>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="col-sm-6">

            <form method="POST"
                action="{{ route('customer_payments.destroy.store', ['customer_payment' => $customer_payment->id]) }}"
                onsubmit="return showWait()">

                @csrf

                <!--customer_id-->
                <div class="form-group">
                    <label for="customer_id">Customer ID</label>
                    <input type="text" class="form-control" id="customer_id"
                        value="{{ $customer_payment->customer_id }}" disabled>
                </div>
                <!--/customer_id-->

                <!--username-->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="{{ $customer_payment->username }}"
                        disabled>
                </div>
                <!--/username-->

                <!--mobile-->
                <div class="form-group">
                    <label for="mobile">mobile</label>
                    <input type="text" class="form-control" id="mobile" value="{{ $customer_payment->mobile }}"
                        disabled>
                </div>
                <!--/mobile-->

                <!--date-->
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" class="form-control" id="date" value="{{ $customer_payment->date }}" disabled>
                </div>
                <!--/date-->

                <!--amount_paid-->
                <div class="form-group">
                    <label for="amount_paid">Amount Paid</label>
                    <input type="text" class="form-control" id="amount_paid"
                        value="{{ $customer_payment->amount_paid }}" disabled>
                </div>
                <!--/amount_paid-->

                <button type="submit" class="btn btn-dark">Submit</button>

            </form>

        </div>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
