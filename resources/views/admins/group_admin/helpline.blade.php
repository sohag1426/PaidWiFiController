@extends ('laraview.layouts.sideNavLayout')

@section('title')
Helpline
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '12';
$active_link = '2';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')

<h3> Helpline </h3>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <dl class="row">
            <dt class="col-sm-4"><i class="fab fa-whatsapp-square"></i> WhatsApp </dt>
            <dd class="col-sm-8">{{ config('consumer.helpline_number') }}</dd>
        </dl>

        <hr>

        <dl class="row">
            <dt class="col-sm-4"><i class="fas fa-envelope-open-text"></i> Email</dt>
            <dd class="col-sm-8">{{ config('consumer.helpline_email') }}</dd>
        </dl>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
