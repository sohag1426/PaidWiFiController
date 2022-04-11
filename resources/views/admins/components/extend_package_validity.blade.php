@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title font-weight-bold">
            Operator/Reseller: {{ $operator->name }} :: Invoice for Extend Package Validity
        </h3>
    </div>

    <div class="card-body">

        <div class="table-responsive-sm">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th scope="col">Package Name</th>
                        <th scope="col">Customer Count</th>
                        <th scope="col">Validity</th>
                        <th scope="col">Customer Price</th>
                        <th scope="col">Operator Price</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($bills as $bill)

                    <tr>
                        <td>{{ $bill->get('package_name') }}</td>
                        <td>{{ $bill->get('customer_count') }}</td>
                        <td>{{ $bill->get('validity') }}</td>
                        <td>{{ $bill->get('customers_amount') }}</td>
                        <td>{{ $bill->get('operators_amount') }}</td>

                    </tr>

                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total Amount: </td>
                        <td>{{ $total_customers_amount}}</td>
                        <td>{{ $total_operators_amount }}</td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="card-footer">

        <div class="row">

            <form method="POST"
                action="{{ route('operators.extend_package_validity.store', ['operator' => $operator->id]) }}"
                onsubmit="return showWait()">

                @csrf

                <button type="submit" class="btn btn-dark">PROCESS</button>

            </form>

            <a class="btn btn-primary ml-4" href="{{ route('customers.index') }}" role="button">CANCEL</a>

        </div>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
