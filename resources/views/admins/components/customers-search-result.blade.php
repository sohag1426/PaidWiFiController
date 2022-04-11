<table class="table table-bordered">

    <thead>

        <tr>
            <th></th>
            <th scope="col">#</th>
            <th scope="col">Mobile &amp; <br> Name</th>
            <th scope="col">Username &amp; <br> Password</th>
            <th scope="col">package &amp; <br> Validity</th>
            <th scope="col">Payment Status &amp; <br> Status </th>
            <th scope="col"></th>
        </tr>

    </thead>

    <tbody>

        <tr>
            <td></td>

            <td scope="row">{{ $customer->id }}</td>

            <td>
                <a href="#" onclick="showCustomerDetails('{{ $customer->id }}')">
                    {{ $customer->mobile }}
                </a>
                <br>
                {{ $customer->name }}
            </td>

            <td>
                {{ $customer->username }}
                <br>
                {{ $customer->password }}
            </td>

            <td>
                {{ $customer->package_name }}
                <br>
                {{ $customer->package_expired_at }}
                <br>
                {{ $customer->remaining_validity }}

            </td>

            <td>
                <span class="{{ $customer->payment_color }}"> {{ $customer->payment_status }} </span>
                <br>
                <span class="{{ $customer->color }}"> {{ $customer->status }} </span>
            </td>

            <td>
                @include('admins.components.actions-on-customers')
            </td>

        </tr>

    </tbody>

</table>
