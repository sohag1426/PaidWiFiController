@extends ('laraview.layouts.sideNavLayout')

@section('title')
Upload PPPoE Profiles
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
<h3> Upload PPPoE Profiles </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="col-sm-6">

            <form id="quickForm" method="POST"
                action="{{ route('routers.pppoe_profiles.store', ['router' => $router->id]) }}"
                onsubmit="return showWait()">

                @csrf

                {{-- Router --}}
                <div class="form-group">
                    <label for="disabledTextInput">Router</label>
                    <input type="text" id="disabledTextInput" class="form-control" placeholder="{{ $router->nasname }}"
                        disabled>
                </div>
                {{-- Router --}}

                {{-- uploded_profiles --}}
                @foreach ($uploded_profiles as $profile)
                <div class="form-check">
                    <input name="pppoe_profiles[]" class="form-check-input" type="checkbox" value="{{ $profile->id }}"
                        id="{{ $profile->id }}" checked>
                    <label class="form-check-label" for="{{ $profile->id }}">
                        {{ $profile->name }}
                    </label>
                </div>
                @endforeach
                {{-- uploded_profiles --}}

                {{-- profiles --}}
                @foreach ($profiles as $profile)
                <div class="form-check">
                    <input name="pppoe_profiles[]" class="form-check-input" type="checkbox" value="{{ $profile->id }}"
                        id="{{ $profile->id }}">
                    <label class="form-check-label" for="{{ $profile->id }}">
                        {{ $profile->name }}
                    </label>
                </div>
                @endforeach
                {{-- profiles --}}

                <button type="submit" class="btn btn-primary mt-2">Submit</button>

            </form>

        </div>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
