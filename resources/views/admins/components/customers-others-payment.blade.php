@section('contentTitle')
Other Payment
@endsection

@section('content')

<div class="card">

    <form id="quickForm" method="POST"
        action="{{ route('customers.others-payments.store', ['customer' => $customer->id]) }}"
        onsubmit="return showWait()">

        <div class="card-body">

            <div class="row">

                <div class="col-sm-6">

                    @csrf

                    <!--name-->
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer->name }}" readonly>
                    </div>
                    <!--/name-->

                    <!--mobile-->
                    <div class="form-group">
                        <label for="mobile">Customer Mobile</label>
                        <input type="text" class="form-control" id="mobile" value="{{ $customer->mobile }}" readonly>
                    </div>
                    <!--/mobile-->

                    <!--amount_paid-->
                    <div class="form-group">

                        <label for="amount_paid"><span class="text-danger">*</span>Amount Paid</label>

                        <input name="amount_paid" type="text"
                            class="form-control @error('amount_paid') is-invalid @enderror" id="amount_paid"
                            value="{{ old('amount_paid') }}" required>

                        @error('amount_paid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <!--/amount_paid-->

                </div>
                <!--/col-sm-6-->

            </div>
            <!--/row-->

        </div>
        <!--/card-body-->

        <div class="card-footer">
            <button type="submit" class="btn btn-dark">SUBMIT</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')
@endsection
