<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name <br> Username</th>
            <th scope="col">Mobile</th>
            <th scope="col">Status</th>
            <th scope="col">Amount Paid</th>
            <th scope="col">Service Charge</th>
            <th scope="col">Store Amount</th>
            {{-- <th scope="col">Payment Type</th> --}}
            <th scope="col">Payment Gateway</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($payments as $payment )
        <tr>
            <th scope="row">{{ $payment->id }}</th>
            <td>
                {{ $payment->name }} <br>
                {{ $payment->username }}
            </td>
            <td>
                <a href="#" onclick="showCustomerDetails('{{ $payment->customer_id }}')">
                    {{ $payment->mobile }}
                </a>
            </td>
            <td>{{ $payment->pay_status }}</td>
            <td>{{ $payment->amount_paid }}</td>
            <td>{{ $payment->transaction_fee }}</td>
            <td>{{ $payment->store_amount }}</td>
            {{-- <td>{{ $payment->type }}</td> --}}
            @if ($payment->type == 'RechargeCard')
            <td>{{ $payment->recharge_card->distributor->name }}</td>
            @else
            <td>{{ $payment->payment_gateway_name }}</td>
            @endif

            <td>

                @if (Auth::user()->can('update', $payment) || Auth::user()->can('delete', $payment))

                <div class="btn-group" role="group">

                    <button id="btnGroupActionsOnCustomer" type="button" class="btn btn-danger dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>

                    <div class="dropdown-menu" aria-labelledby="btnGroupActionsOnCustomer">
                        {{--  --}}
                        @can('update', $payment)
                        <a class="dropdown-item"
                            href="{{ route('customer_payments.edit.create', ['customer_payment' => $payment->id]) }}">
                            Edit
                        </a>
                        @endcan
                        {{--  --}}
                        @can('delete', $payment)
                        <a class="dropdown-item"
                            href="{{ route('customer_payments.destroy.create', ['customer_payment' => $payment->id]) }}">
                            Delete
                        </a>
                        @endcan
                        {{--  --}}
                    </div>

                </div>

                @endif

            </td>

        </tr>
        @endforeach

    </tbody>
</table>
