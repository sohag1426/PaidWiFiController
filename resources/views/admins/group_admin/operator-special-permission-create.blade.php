@extends ('laraview.layouts.sideNavLayout')

@section('title')
Assign Special Permission
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '1';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')
<h3>Assign Special Permission</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="col-sm-6">

            <form id="quickForm" method="POST"
                action="{{ route('operators.special-permission.store', ['operator' => $operator->id]) }}">

                @csrf

                {{-- operator --}}
                <div class="form-group">
                    <label for="disabledTextInput">operator</label>
                    <input type="text" id="disabledTextInput" class="form-control" placeholder="{{ $operator->name }}"
                        disabled>
                </div>
                {{-- operator --}}

                <div class="card-header font-weight-bold">Select Permissions</div>

                {{-- selected_permission --}}
                @foreach ($selected_permissions as $selected_permission)
                <div class="form-check">
                    <input name="permissions[]" class="form-check-input" type="checkbox"
                        value="{{ $selected_permission }}" id="{{ $selected_permission }}" checked>
                    <label class="form-check-label" for="{{ $selected_permission }}">
                        {{ $selected_permission }}
                    </label>
                </div>
                @endforeach

                {{-- selected_permission --}}

                {{-- new_permission --}}
                @foreach ($new_permissions as $new_permission)
                <div class="form-check">
                    <input name="permissions[]" class="form-check-input" type="checkbox" value="{{ $new_permission }}"
                        id="{{ $new_permission }}">
                    <label class="form-check-label" for="{{ $new_permission }}">
                        {{ $new_permission }}
                    </label>
                </div>
                @endforeach
                {{-- new_permission --}}

                <button type="submit" class="btn btn-primary mt-2">Submit</button>

            </form>

        </div>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
