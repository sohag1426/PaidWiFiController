@extends ('laraview.layouts.sideNavLayout')

@section('title')
Fair Usage Policy Create
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
<h3> Create Fair Usage Policy </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST"
            action="{{ route('master_packages.fair_usage_policy.store', ['master_package' => $master_package->id]) }}"
            onsubmit="return showWait()">

            @csrf

            <div class="col-sm-6">

                <!--name-->
                <div class="form-group">
                    <label for="name">Package Name</label>
                    <input type="text" class="form-control" id="name" value="{{ $master_package->name }}" disabled>
                </div>
                <!--/name-->

                <!--data_limit-->
                <div class="form-group">
                    <label for="data_limit"><span class="text-danger">*</span>If the data usage exceeds</label>

                    <div class="input-group">
                        <input name="data_limit" type="number"
                            class="form-control @error('data_limit') is-invalid @enderror" id="data_limit" required>
                        <div class="input-group-append">
                            <span class="input-group-text">GB</span>
                        </div>
                    </div>

                </div>
                <!--/data_limit-->

                <!--speed_limit-->
                <div class="form-group">
                    <label for="speed_limit"><span class="text-danger">*</span>The speed limit will drop to</label>

                    <div class="input-group">
                        <input name="speed_limit" type="number"
                            class="form-control @error('speed_limit') is-invalid @enderror" id="speed_limit" required>
                        <div class="input-group-append">
                            <span class="input-group-text">Mbps</span>
                        </div>
                    </div>

                </div>
                <!--/speed_limit-->

                <!--ipv4pool_id-->
                <div class="form-group">
                    <label for="ipv4pool_id"><span class="text-danger">*</span>And customer will get IPv4 address from
                    </label>
                    <select class="form-control" id="ipv4pool_id" name="ipv4pool_id" required>
                        @foreach ($ipv4pools as $ipv4pool)
                        <option value="{{ $ipv4pool->id }}">{{ $ipv4pool->name }}
                            ({{ long2ip($ipv4pool->subnet).'/'. $ipv4pool->mask }})</option>
                        @endforeach
                    </select>
                    @error('ipv4pool_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <!--/ipv4pool_id-->

            </div>
            <!--/col-sm-6-->

            <div class="col-sm-6">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>

        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
