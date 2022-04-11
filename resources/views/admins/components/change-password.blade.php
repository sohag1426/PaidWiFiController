@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST" action="{{ route('admin.password.change') }}">
            @csrf

            <div class="col-sm-6">

                <!--password-->
                <div class="form-group">
                    <label for="password"><span class="text-danger">*</span>Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/password-->


                <!--password-confirm-->
                <div class="form-group">
                    <label for="password-confirm"><span class="text-danger">*</span>Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password">

                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/password-confirm-->

                <button type="submit" class="btn btn-dark">Change Password</button>

            </div>
            <!--/col-sm-6-->
        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
