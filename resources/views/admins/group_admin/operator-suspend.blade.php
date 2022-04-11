@extends ('laraview.layouts.sideNavLayout')

@section('title')
Suspend Operator
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
<h3> Suspend Operator </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="col-sm-6">

            <form id="quickForm" method="POST"
                action="{{ route('operators.suspend.store', ['operator' => $operator->id]) }}"
                onsubmit="return showWait()">

                @csrf

                {{-- operator --}}
                <div class="form-group">
                    <label for="disabledTextInput">operator</label>
                    <input type="text" id="disabledTextInput" class="form-control" placeholder="{{ $operator->name }}"
                        disabled>
                </div>
                {{-- operator --}}

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="suspend_customers" value="suspend_customers"
                        id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Suspend Customers
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Submit</button>

            </form>

        </div>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
