@extends ('laraview.layouts.topNavLayout')

@section('title')
Found in Other Network
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
<h3>Mobile number already registered</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                The mobile number {{ $customer->mobile }} already registered with {{ $customer->company }}
            </li>
            <li class="list-group-item">
                Please use different mobile number to register with {{ $new_network }}
            </li>
        </ul>

        <a class="btn btn-dark" href="{{ $customer->link_login_only }}" role="button" onclick="showWait()">
            Go To Login Page
        </a>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
