@extends ('laraview.layouts.sideNavLayout')

@section('title')
Routers
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '2';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')
<h3>Configure Router</h3>
@endsection

@section('content')

<div class="card">

    <form id="quickForm" method="POST" action="{{ route('routers.configuration.store', ['router' => $router->id]) }}"
        onsubmit="return showWait()">
        @csrf
        <div class="card-body">

            <!--router-->
            <div class="form-group">
                <label for="router">Router</label>
                <input type="text" class="form-control" id="router"
                    value="{{ $router->nasname }} :: {{ $router->location }}" disabled>
            </div>
            <!--/router-->

            <!--operator_id-->
            <div class="form-group">
                <label for="operator_id">Operator</label>
                <select name="operator_id" id="operator_id" class="form-control select2" required>
                    @foreach ($operators as $operator )
                    <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                    @endforeach
                </select>
            </div>
            <!--/operator_id-->

            {{-- change_system_identity --}}
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="change_system_identity" value="yes"
                    id="defaultCheck1" checked>
                <label class="form-check-label" for="defaultCheck1">
                    Modify System Identity
                </label>
            </div>
            {{-- change_system_identity --}}

        </div>
        <!--/card-body-->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!--/card-footer-->

        <div class="card-body">

            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Alert!</h4>
                <p>Before configuring please update your RouterOS to latest Long-term or Stable version.</p>
                <hr>
                <p>Before configuring please setup hotspot servers(If Require).</p>
                <hr>
                <p class="mb-0">Self registered hotspot customers will belong to the selected operator.</p>
                <hr>
                <p class="mb-0">If the hotspot service is running on the router, Modify System Identity is Required.</p>
                <hr>
                <p class="mb-0">If you want to monitor ppp users live traffic, Modify System Identity is Required.</p>
            </div>

        </div>

    </form>

</div>

@endsection

@section('pageJs')
@endsection
