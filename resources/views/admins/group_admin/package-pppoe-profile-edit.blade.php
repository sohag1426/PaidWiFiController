@extends ('laraview.layouts.sideNavLayout')

@section('title')
Package PPP Profile Edit
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
<h3>Package PPP Profile Edit</h3>
@endsection

@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form method="POST"
        action="{{ route('master_packages.pppoe_profiles.update', ['master_package' => $master_package->id, 'pppoe_profile' => $pppoe_profile->id]) }}"
        onsubmit="return showWait()">

        @csrf

        @method('put')

        <div class="card-body">

            <!--Package-->
            <div class="form-group">
                <label for="package">Package Name</label>
                <input type="text" class="form-control" id="package" value="{{ $master_package->name }}" disabled>
            </div>
            <!--/Package-->

            <!--name-->
            <div class="form-group">
                <label for="name">PPP Profile (To be Replaced)</label>

                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    value="{{ $pppoe_profile->name }} :: {{ long2ip($pppoe_profile->ipv4pool->subnet).'/'. $pppoe_profile->ipv4pool->mask }} :: {{ $pppoe_profile->ipv6pool->prefix }}"
                    disabled>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <!--/name-->

            <!--pppoe_profile_id-->
            <div class="form-group">
                <label for="pppoe_profile_id"><span class="text-danger">*</span>Select PPP Profile</label>
                <select class="form-control" id="pppoe_profile_id" name="pppoe_profile_id" required>
                    <option value="">Please select...</option>
                    @foreach ($profiles as $profile)
                    <option value="{{ $profile->id }}">
                        {{ $profile->name }}
                        :: {{ long2ip($profile->ipv4pool->subnet).'/'. $profile->ipv4pool->mask }}
                        :: {{ $profile->ipv6pool->prefix }}
                    </option>
                    @endforeach
                </select>
                @error('pppoe_profile_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/pppoe_profile_id-->

        </div>
        <!--/Card Body-->

        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Submit</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')
@endsection
