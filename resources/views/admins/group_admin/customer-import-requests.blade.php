@extends ('laraview.layouts.sideNavLayout')

@section('title')
Customer Import Requests
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '5';
$active_link = '4';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')

<ul class="nav flex-column flex-sm-row ml-4">

    <!--New Import Request-->
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('pppoe_customers_import.create') }}">
            <i class="fas fa-plus"></i>
            New Import Request
        </a>
    </li>
    <!--/New Import Request-->
</ul>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <h5 class="card-title mb-2">Customer Import Requests</h5>

        <table id="data_table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="width: 2%">#</th>
                    <th scope="col">Request By</th>
                    <th scope="col">Requested For</th>
                    <th scope="col">Router</th>
                    <th scope="col">billing profile</th>
                    <th scope="col">Import disabled user</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($requests as $request )
                <tr>
                    <td scope="row">{{ $request->id }}</td>
                    <td>{{ $request->groupAdmin->name }}</td>
                    <td>{{ $request->operator->name }}</td>
                    <td>{{ $request->router->location }} :: {{ $request->router->nasname }}</td>
                    <td>{{ $request->billingProfile->name }}</td>
                    <td>{{ $request->import_disabled_user }}</td>
                    <td>{{ $request->date }}</td>
                    <td>{{ $request->status }}</td>
                    <td>
                        <a
                            href="{{ route('pppoe_customers_import.show', ['pppoe_customers_import' => $request->id]) }}">
                            Details
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <!--/card-body-->

</div>

@endsection

@section('pageJs')
@endsection
