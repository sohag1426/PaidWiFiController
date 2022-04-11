@extends ('laraview.layouts.sideNavLayout')

@section ('title')
Dashboard
@endsection

@section ('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '0';
$active_link = '0';
@endphp
@endsection

@section ('sidebar')
@include('admins.group_admin.sidebar')
@endsection

@section('contentTitle')
<h3>Dashboard</h3>
@endsection

@section('content')

{{-- widgets --}}
<div class="card card-outline card-info border-left border-info">

    <div class="card-body">

        {{-- Second row --}}
        <div class="row">

            {{-- Active Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="active_customers">0</h3>
                        <p>Active Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-creative-commons-sampling"></i>
                    </div>
                    <a href="{{ route('customers.index', ['status' => 'active']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Active Customers --}}

            {{-- Suspended Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="suspended_customers">0</h3>
                        <p>Suspended Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    <a href="{{ route('customers.index', ['status' => 'suspended']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Suspended Customers --}}

            {{-- Online Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="online_customers">0</h3>
                        <p>
                            Online Customers
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <a href="{{ route('online_customers.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Online Customers --}}

        </div>
        {{-- Second row --}}

    </div>

</div>
{{-- widgets --}}


@endsection

@section('pageJs')

<script>

    $.get( "/widgets/online_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#online_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#online_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/active_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#active_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#active_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/suspend_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#suspended_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#suspended_customers').text(this.countNum);
                }
            });
        });

</script>

@endsection
