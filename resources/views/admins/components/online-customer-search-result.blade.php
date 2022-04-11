<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Username</th>
            <th scope="col">MAC Addresses</th>
            <th scope="col">IP Address</th>
            <th scope="col">Download</th>
            <th scope="col">Upload</th>
            <th scope="col">UP Time</th>
            <th scope="col">Updated At</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <a href="#" onclick="showCustomerDetails('{{ $radacct->customer->id }}')">
                    {{ $radacct->username }}
                </a>
            </td>
            <td>{{ $radacct->callingstationid }}</td>
            <td>{{ $radacct->framedipaddress }}</td>
            <td>{{ $radacct->acctoutputoctets/1000/1000/1000 }} GB</td>
            <td>{{ $radacct->acctinputoctets/1000/1000/1000 }} GB</td>
            <td>{{ sToHms($radacct->acctsessiontime) }}</td>
            <td>{{ $radacct->acctupdatetime }}</td>
        </tr>
    </tbody>
</table>
