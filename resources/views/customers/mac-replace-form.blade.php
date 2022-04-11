@extends ('laraview.layouts.topNavLayout')

@section('title')
Mobile Verification
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
<h3>Verify it's you</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        A verification PIN has been sent to your mobile number : {{ $customer->mobile }}
    </div>

    <div class="card-body">
        <div class="col-sm-6">

            <form id="quickForm" method="POST"
                action="{{ route('customer.replace.mac', ['mobile' => $customer->mobile]) }}"
                onsubmit="return showWait()">
                @csrf

                <!--otp-->
                <div class="form-group">
                    <label for="otp"><span class="text-danger">*</span>Verification PIN</label>
                    <input name="otp" type="text" class="form-control @error('otp') is-invalid @enderror" id="otp"
                        value="{{ old('otp') }}" required>
                    @error('otp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <!--/otp-->

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

</div>

@endsection

@section('pageJs')
@endsection
