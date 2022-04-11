@section('contentTitle')

{{-- @Filter --}}
@if ($operators)
<form class="d-flex align-content-start flex-wrap" action="{{ route('customers-pending-payments.index') }}"
    method="get">

    {{-- operator --}}
    <div class="form-group col-md-2">
        <select name="operator_id" id="operator_id" class="form-control">
            <option value=''>operator...</option>
            @foreach ($operators as $operator)
            <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
            @endforeach
        </select>
    </div>
    {{--operator --}}

    {{-- mobile --}}
    <div class="form-group col-md-2">
        <input type="text" name="mobile" class="form-control" placeholder="mobile...">
    </div>
    {{--mobile --}}

    <div class="form-group col-md-1">
        <button type="submit" class="btn btn-dark">FILTER</button>
    </div>

</form>
@endif
{{-- @endFilter --}}

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Status</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Payment Gateway</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($payments as $payment )
                <tr>
                    <th scope="row">{{ $payment->id }}</th>
                    <td>{{ $payment->mobile }}</td>
                    <td>{{ $payment->pay_status }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->payment_gateway_name }}</td>
                    <td>
                        <form method="post"
                            action="{{ route('customers-pending-payments.update', ['customer_payment' => $payment->id]) }}">
                            @csrf
                            @method('put')
                            <button type="submit">Recheck</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <!--/card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Entries: {{ $payments->total() }}
            </div>
            <div class="col-sm-6">
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')
@endsection
