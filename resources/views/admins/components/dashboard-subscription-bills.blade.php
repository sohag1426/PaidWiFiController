<table class="table table-striped table-valign-middle">

    <thead>
        <th scope="col">#</th>
        <th scope="col">Operator</th>
        <th scope="col">Customer Count</th>
        <th scope="col">Amount</th>
        <th scope="col">Billing Month</th>
        <th scope="col"></th>
    </thead>

    <tbody>

        @foreach ($subscription_bills as $subscription_bill )
        <tr>
            <td>{{ $subscription_bill->id }}</td>
            <td>{{ $subscription_bill->operator_name }}</td>
            <td>{{ $subscription_bill->user_count }}</td>
            <td>{{ $subscription_bill->amount }}</td>
            <td>{{ $subscription_bill->month }} - {{ $subscription_bill->year }}</td>
            <td>
                <a class="btn btn-info btn-sm" href="{{ route('subscription_bills.index') }}">
                    Pay Now
                </a>
            </td>
        </tr>
        @endforeach

    </tbody>

</table>
