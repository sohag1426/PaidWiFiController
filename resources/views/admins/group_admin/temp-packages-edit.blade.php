@extends ('laraview.layouts.sideNavLayout')

@section('title')
New Package
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

<ul class="nav flex-column flex-sm-row">

    <li class="nav-item">
        <h3>New Package</h3>
    </li>

    <li class="nav-item ml-4">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('pppoe_profiles.create') }}">
            <i class="fas fa-plus"></i>
            New PPP Profile
        </a>
    </li>
</ul>

@endsection

@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form method="POST" action="{{ route('temp_packages.update',['temp_package' => $temp_package->id]) }}">

        @csrf

        @method('put')

        <div class="card-body">

            <div class="row">

                <div class="col-6">

                    <!--pppoe_profile_id-->
                    <div class="form-group">
                        <label for="pppoe_profile_id"><span class="text-danger">*</span>Select PPP Profile</label>
                        <select class="form-control" id="pppoe_profile_id" name="pppoe_profile_id" required>
                            @foreach ($profiles as $profile)
                            <option value="{{ $profile->id }}">{{ $profile->name }}</option>
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

            </div>

        </div>
        <!--/Card Body-->

        <div class="card-footer">
            <button type="submit" class="btn btn-dark">NEXT</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')
@endsection
