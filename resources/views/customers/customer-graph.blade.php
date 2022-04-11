@extends ('laraview.layouts.topNavLayout')

@section('title')
Internet Graph
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
{{-- Logout Button --}}
@include('customers.logout-nav')
{{-- Logout Button --}}
@endsection

@section('content')

<div class="card">

    {{-- Navigation bar --}}
    <div class="card-header">
        @php
        $active_link = '7';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <div id="live_traffic"> </div>

    <div class="card-body">
        <h5>Hourly Graph</h5>
        <div>
            <img class="img-fluid" src="{{ $graph->get('hourly') }}" alt="Image Not Found">
        </div>
    </div>

    <div class="card-body">
        <h5>Daily Graph</h5>
        <div>
            <img class="img-fluid" src="{{ $graph->get('daily') }}" alt="Image Not Found">
        </div>
    </div>

    <div class="card-body">
        <h5>Weekly Graph</h5>
        <div>
            <img class="img-fluid" src="{{ $graph->get('weekly') }}" alt="Image Not Found">
        </div>
    </div>

    <div class="card-body">
        <h5>Monthly Graph</h5>
        <div>
            <img class="img-fluid" src="{{ $graph->get('monthly') }}" alt="Image Not Found">
        </div>
    </div>

    <div class="card-body">
        <a href="{{ route('customers.packages',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">
            Buy Package
        </a>
        <a href="{{ route('customers.profile',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">
            Profile
        </a>
    </div>

</div>

@endsection

@section('pageJs')
<script>
    $(document).ready(function() {

        let liv_url = "{{ route('customers.live_traffic', ['mobile' => $customer->mobile]) }}";

        let interval_id = setInterval(function() {

            $.ajax({
                url: liv_url
            }).done(function(data) {

                if (data == "0") {
                    clearInterval(interval_id);
                } else {
                    $("#live_traffic").html(data);
                }
            }).fail(function() {
                clearInterval(interval_id);
            });

        }, 3000);

    });
</script>
@endsection
