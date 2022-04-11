<table class="table table-striped table-valign-middle">

    <thead>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Mobile</th>
        <th scope="col">package</th>
        <th scope="col">Amount</th>
        <th scope="col">Due Date</th>
    </thead>

    <tbody>

        @foreach ($bills as $bill )
        <tr>
            <td>{{ $bill->id }}</td>
            <td>{{ $bill->username }}</td>
            <td>{{ $bill->mobile }}</td>
            <td>{{ $bill->description }}</td>
            <td>{{ $bill->amount }}</td>
            <td>{{ $bill->due_date }}</td>
        </tr>
        @endforeach

        <tr>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
        </tr>

        <tr>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>Total: </td>
            <td>{{ $total_amount }}</td>
            <td>{{ config('consumer.currency') }}</td>
        </tr>

    </tbody>

</table>
