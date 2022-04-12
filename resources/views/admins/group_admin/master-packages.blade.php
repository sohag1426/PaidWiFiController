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
                <option value="Hotspot">Hotspot</option>
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

@endsection

@section('pageJs')
@endsection
