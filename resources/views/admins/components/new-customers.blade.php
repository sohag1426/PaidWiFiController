<table class="table table-striped table-valign-middle">

    <thead>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Mobile</th>
        <th scope="col">Package</th>
        <th scope="col">Created At</th>
    </thead>

    <tbody>

        @foreach ($customers as $customer )
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->username }}</td>
            <td>{{ $customer->mobile }}</td>
            <td>{{ $customer->package_name }}</td>
            <td>{{ $customer->created_at }}</td>
        </tr>
        @endforeach

        <tr>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
        </tr>

    </tbody>

</table>
