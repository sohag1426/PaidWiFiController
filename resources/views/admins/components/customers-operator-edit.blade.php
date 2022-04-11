@section('contentTitle')
<h3>Change Operator</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">

                <form method="POST"
                    action="{{ route('customers.change_operator.store', ['customer' => $customer->id]) }}">

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

                    <!--operator_id-->
                    <div class="form-group">
                        <label for="operator_id"><span class="text-danger">*</span>Select New Operator</label>
                        <select class="form-control" id="operator_id" name="operator_id" required>
                            <option value="">Please select...</option>
                            @foreach ($operators as $operator)
                            <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <!--/operator_id-->

                    <button type="submit" class="btn btn-dark">SUBMIT</button>

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
