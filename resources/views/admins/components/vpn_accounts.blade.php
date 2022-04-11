@section('contentTitle')

<ul class="nav flex-column flex-sm-row">
    <!--New Account-->
    <li class="nav-item mr-2">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('vpn_accounts.create') }}">
            <i class="fas fa-plus"></i>
            New Account
        </a>
    </li>
    <!--/New Account-->
</ul>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <table id="data_table" class="table table-bordered">

            <thead>
                <tr>
                    <th scope="col" style="width: 2%">#</th>
                    <th scope="col">Operator</th>
                    <th scope="col">winbox</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">VPN Type</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($vpn_accounts as $vpn_account )
                <tr>
                    <th scope="row">{{ $vpn_account->id }}</th>
                    <td>{{ $vpn_account->operator->id }} :: {{ $vpn_account->operator->name }}</td>
                    <td>{{ $vpn_account->server_ip }}:{{ $vpn_account->winbox_port }}</td>
                    <td>{{ long2ip($vpn_account->ip_address) }}</td>
                    <td>{{ $vpn_account->vpn_type }}</td>
                    <td>

                        <div class="btn-group" role="group">

                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>

                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                {{-- Configure --}}
                                <a class="dropdown-item"
                                    href="{{ route('vpn_accounts.show', ['vpn_account' => $vpn_account->id]) }}">
                                    config info
                                </a>
                                {{-- Configure --}}

                                {{-- Delete --}}
                                <form method="post"
                                    action="{{ route('vpn_accounts.destroy', ['vpn_account' => $vpn_account->id]) }}"
                                    onsubmit="return confirm('Are you sure to Delete')">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item" type="submit">Delete</button>
                                </form>
                                {{-- Delete --}}
                            </div>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
