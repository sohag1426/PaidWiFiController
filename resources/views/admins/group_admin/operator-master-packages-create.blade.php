@extends ('laraview.layouts.sideNavLayout')

@section('title')
Add Package
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
if(Auth::user()->id == $operator->id){
$active_menu = '2';
$active_link = '7';
} else {
$active_menu = '1';
$active_link = '1';
}
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')
<h3> Assign Package </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title font-weight-bold">Operator: {{ $operator->name }}</h3>
    </div>

</div>

<form id="quickForm" method="POST"
    action="{{ route('operators.master_packages.store', ['operator' => $operator->id]) }}">

    @csrf

    {{-- PPP Packages --}}
    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">PPP Packages</h3>
        </div>

        <div class="card-body">

            {{-- Select Package --}}
            @foreach ($packages->where('connection_type', 'PPPoE')->sortBy('name') as $package)
            <div class="form-check">
                <input name="package_id" class="form-check-input" type="radio" value="{{ $package->id }}"
                    id="{{ $package->id }}">
                <label class="form-check-label" for="{{ $package->id }}">
                    {{ $package->name }}
                </label>
            </div>
            @endforeach
            {{-- Select Package --}}

        </div>

    </div>
    {{-- PPP Packages --}}

    {{-- Hotspot Packages --}}
    <div class="card card-outline card-secondary">

        <div class="card-header">
            <h3 class="card-title">Hotspot Packages</h3>
        </div>

        <div class="card-body">

            {{-- Select Package --}}
            @foreach ($packages->where('connection_type', 'Hotspot')->sortBy('name') as $package)
            <div class="form-check">
                <input name="package_id" class="form-check-input" type="radio" value="{{ $package->id }}"
                    id="{{ $package->id }}">
                <label class="form-check-label" for="{{ $package->id }}">
                    {{ $package->name }}
                </label>
            </div>
            @endforeach
            {{-- Select Package --}}

        </div>

    </div>
    {{-- Hotspot Packages --}}

    {{-- Static IP Packages --}}

    <div class="card card-outline card-warning">

        <div class="card-header">
            <h3 class="card-title">Static IP Packages</h3>
        </div>

        <div class="card-body">

            {{-- Select Package --}}
            @foreach ($packages->where('connection_type', 'StaticIp')->sortBy('name') as $package)
            <div class="form-check">
                <input name="package_id" class="form-check-input" type="radio" value="{{ $package->id }}"
                    id="{{ $package->id }}">
                <label class="form-check-label" for="{{ $package->id }}">
                    {{ $package->name }}
                </label>
            </div>
            @endforeach
            {{-- Select Package --}}

        </div>

    </div>

    {{-- Static IP Packages --}}

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary mt-2">Next</button>
        </div>
    </div>

</form>

@endsection

@section('pageJs')
@endsection
