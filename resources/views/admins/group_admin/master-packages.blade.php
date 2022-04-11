@extends ('laraview.layouts.sideNavLayout')

@section('title')
Master Packages
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '2';
$active_link = '6';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')

<form action="{{ route('temp_packages.store') }}" method="POST">

    @csrf

    <ul class="nav flex-column flex-sm-row">

        <!--connection_type-->
        <li class="nav-item">
            <select name="connection_type" class="custom-select mr-sm-2" required>
                <option selected value="">Connection Type...</option>
                <option value="PPPoE">PPPoE</option>
                <option value="Hotspot">Hotspot</option>
                <option value="StaticIp">StaticIp</option>
            </select>
        </li>
        <!--/connection_type-->

        <li class="nav-item">
            <button type="submit" class="btn btn-primary ml-2"> <i class="fas fa-plus"></i> New Package</button>
        </li>

    </ul>

</form>

@endsection

@section('content')

<!--modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-fup">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Fair Usage Policy</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalBody">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /modal -->

{{-- PPP Packages --}}
<div class="card card-outline card-primary">

    <div class="card-header">
        <h3 class="card-title">PPP Packages</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive-sm">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th scope="col" style="width: 2%">#</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Rate Limit</th>
                        <th scope="col">Volume Limit</th>
                        <th scope="col">Validity</th>
                        <th scope="col">Customer Count</th>
                        <th scope="col">Operators</th>
                        <th scope="col"></th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($master_packages->where('connection_type', 'PPPoE')->sortBy('name') as $master_package)

                    <tr>
                        <td>{{ $master_package->id }}</td>
                        <td>
                            {{ $master_package->name }}
                            <br>
                            IPv4:
                            {{ long2ip($master_package->pppoe_profile->ipv4pool->subnet).'/'. $master_package->pppoe_profile->ipv4pool->mask }}
                            <br>
                            IPv6: {{ $master_package->pppoe_profile->ipv6pool->prefix }}
                        </td>
                        <td>{{ $master_package->rate_limit }} {{ $master_package->readable_rate_unit }}</td>
                        <td>{{ $master_package->volume_limit }} {{ $master_package->volume_unit }}</td>
                        <td>{{ $master_package->validity }}</td>
                        <td>{{ $master_package->customer_count }}</td>
                        <td>
                            @foreach ($master_package->operators as $operator)
                            <li>{{ $operator->name }}</li>
                            @endforeach
                        </td>

                        <td>

                            <div class="btn-group dropleft" role="group">

                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>

                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                    @can('update', $master_package)
                                    {{-- update --}}
                                    <a class="dropdown-item"
                                        href="{{ route('master_packages.edit', ['master_package' => $master_package->id]) }}">
                                        Edit
                                    </a>
                                    {{-- update --}}

                                    {{-- Fair Usage Policy --}}
                                    <a class="dropdown-item" href="#"
                                        onclick="showFup('{{ route('master_packages.fair_usage_policy.index', ['master_package' => $master_package->id]) }}')">
                                        Fair Usage Policy
                                    </a>
                                    {{-- Fair Usage Policy --}}

                                    {{-- Change PPP Profile --}}
                                    <a class="dropdown-item"
                                        href="{{ route('master_packages.pppoe_profiles.edit', ['master_package' => $master_package->id, 'pppoe_profile' => $master_package->pppoe_profile_id]) }}">
                                        Change PPP Profile
                                    </a>
                                    {{-- Change PPP Profile --}}
                                    @endcan

                                    {{-- delete --}}
                                    @can('delete', $master_package)
                                    <form method="post"
                                        action="{{ route('master_packages.destroy', ['master_package' => $master_package->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                                    </form>
                                    @endcan
                                    {{-- delete --}}

                                </div>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
{{-- PPP Packages --}}

{{-- Hotspot Packages --}}
<div class="card card-outline card-secondary">

    <div class="card-header">
        <h3 class="card-title">Hotspot Packages</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive-sm">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th scope="col" style="width: 2%">#</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Rate Limit</th>
                        <th scope="col">Volume Limit</th>
                        <th scope="col">Validity</th>
                        <th scope="col">Customer Count</th>
                        <th scope="col">Operators</th>
                        <th scope="col"></th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($master_packages->where('connection_type', 'Hotspot')->sortBy('name') as $master_package)

                    <tr>
                        <td>{{ $master_package->id }}</td>
                        <td>{{ $master_package->name }}</td>
                        <td>{{ $master_package->rate_limit }} {{ $master_package->readable_rate_unit }}</td>
                        <td>{{ $master_package->volume_limit }} {{ $master_package->volume_unit }}</td>
                        <td>{{ $master_package->validity }}</td>
                        <td>{{ $master_package->customer_count }}</td>
                        <td>
                            @foreach ($master_package->operators as $operator)
                            <li>{{ $operator->name }}</li>
                            @endforeach
                        </td>

                        <td>

                            <div class="btn-group dropleft" role="group">

                                <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>

                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">

                                    {{-- Edit --}}
                                    @can('update', $master_package)
                                    <a class="dropdown-item"
                                        href="{{ route('master_packages.edit', ['master_package' => $master_package->id]) }}">
                                        Edit
                                    </a>
                                    @endcan
                                    {{-- Edit --}}

                                    {{-- delete --}}
                                    @can('delete', $master_package)
                                    <form method="post"
                                        action="{{ route('master_packages.destroy', ['master_package' => $master_package->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                                    </form>
                                    @endcan
                                    {{-- delete --}}

                                </div>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
{{-- Hotspot Packages --}}

{{-- Static IP Packages --}}
<div class="card card-outline card-warning">

    <div class="card-header">
        <h3 class="card-title">Static IP Packages</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive-sm">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th scope="col" style="width: 2%">#</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Rate Limit</th>
                        <th scope="col">Volume Limit</th>
                        <th scope="col">Validity</th>
                        <th scope="col">Customer Count</th>
                        <th scope="col">Operators</th>
                        <th scope="col"></th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($master_packages->where('connection_type', 'StaticIp')->sortBy('name') as $master_package)

                    <tr>
                        <td>{{ $master_package->id }}</td>
                        <td>{{ $master_package->name }}</td>
                        <td>{{ $master_package->rate_limit }} {{ $master_package->readable_rate_unit }}</td>
                        <td>{{ $master_package->volume_limit }} {{ $master_package->volume_unit }}</td>
                        <td>{{ $master_package->validity }}</td>
                        <td>{{ $master_package->customer_count }}</td>
                        <td>
                            @foreach ($master_package->operators as $operator)
                            <li>{{ $operator->name }}</li>
                            @endforeach
                        </td>

                        <td>

                            <div class="btn-group dropleft" role="group">

                                <button id="btnGroupDrop3" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>

                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop3">

                                    {{-- Edit --}}
                                    @can('update', $master_package)
                                    <a class="dropdown-item"
                                        href="{{ route('master_packages.edit', ['master_package' => $master_package->id]) }}">
                                        Edit
                                    </a>
                                    @endcan
                                    {{-- Edit --}}

                                    {{-- delete --}}
                                    @can('delete', $master_package)
                                    <form method="post"
                                        action="{{ route('master_packages.destroy', ['master_package' => $master_package->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                                    </form>
                                    @endcan
                                    {{-- delete --}}

                                </div>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
</div>
{{-- Static IP Packages --}}

@endsection

@section('pageJs')
<script>
    function showFup(url)
    {
        $.get(url, function( data ) {
            $('#modal-fup').modal('show');
            $("#ModalBody").html(data);
        });
    }
</script>
@endsection
