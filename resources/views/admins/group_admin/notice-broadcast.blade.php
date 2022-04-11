@extends ('laraview.layouts.sideNavLayout')

@section('title')
Notice Broadcast
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '1';
$active_link = '3';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')
<h3>Notice Broadcast</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">


                <form method="POST" action="{{ route('operators-notice-broadcast.store') }}">

                    @csrf

                    <!--operators_count-->
                    <div class="form-group">

                        <label for="operators_count">Number of Recipient</label>

                        <input type="text" class="form-control" id="operators_count" value="{{ $operators_count }}"
                            disabled>

                    </div>
                    <!--/operators_count-->


                    <!--text_message-->
                    <div class="form-group">
                        <label for="text_message">Text Message</label>
                        <textarea class="form-control" id="text_message" name="text_message" rows="3"
                            required></textarea>
                    </div>
                    <!--/text_message-->

                    <button type="submit" class="btn btn-dark">SUBMIT</button>

                </form>

            </div>
            <!--/col-sm-6-->
        </div>
        <!--/row-->
    </div>
    <!--/card-body-->
</div>

@endsection

@section('pageJs')
@endsection
