@section('contentTitle')
<h3>New distributor payment</h3>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <div class="row">
            <div class="col-sm-6">
                <form id="quickForm" method="POST" action="{{ route('distributor_payments.store') }}">
                    @csrf

                    <!-- card_distributor_id -->
                    <div class="form-group">
                        <label for="card_distributor_id"><span class="text-danger">*</span>Distributor</label>
                        <select name="card_distributor_id" id="card_distributor_id" class="form-control" required>
                            <option value="">please select...</option>
                            @foreach ($distributors as $distributor)
                            <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <!--/card_distributor_id -->

                    <!--amount_paid-->
                    <div class="form-group">
                        <label for="amount_paid"><span class="text-danger">*</span>Amount Paid</label>
                        <input name="amount_paid" type="text"
                            class="form-control @error('amount_paid') is-invalid @enderror" id="amount_paid"
                            value="{{ old('amount_paid') }}" autocomplete="amount_paid" required>
                        @error('amount_paid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/amount_paid-->

                    <button type="submit" class="btn btn-dark">Submit</button>

                </form>

            </div>
            <!--/col-sm-6-->

        </div>
        <!--/row-->

    </div>
    <!--/card-body-->

</div>

@endsection

@section('pageJs')
@endsection
