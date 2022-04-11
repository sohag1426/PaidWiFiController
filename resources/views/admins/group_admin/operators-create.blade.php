@extends ('laraview.layouts.sideNavLayout')

@section('title')
New Operator
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
<h3>New Operator</h3>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <div class="row">
            <div class="col-sm-6">
                <form id="quickForm" autocomplete="off" method="POST" action="{{ route('operators.store') }}">
                    @csrf

                    <!--company-->
                    <div class="form-group">
                        <label for="company"><span class="text-danger">*</span>Company</label>
                        <input name="company" type="text" class="form-control @error('company') is-invalid @enderror"
                            id="company" value="{{ Auth::user()->company }}" required>
                        @error('company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/company-->

                    <!-- account_type -->
                    <div class="form-group">
                        <label for="account_type"><span class="text-danger">*</span>Account Type</label>
                        <select name="account_type" id="account_type" class="form-control"
                            onchange="showAccountTypeOption(this.value)" required>
                            <option value="">Please Select...</option>
                            <option value="credit">Credit/Postpaid</option>
                            <option value="debit">Debit/Prepaid</option>
                        </select>
                    </div>
                    <!--/account_type -->

                    <!--account_type_option-->
                    <div id="account_type_option">
                    </div>
                    <!--/account_type_option-->

                    <!--name-->
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span>Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name') }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/name-->

                    <!--mobile-->
                    <div class="form-group">
                        <label for="mobile"><span class="text-danger">*</span>Mobile</label>
                        <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                            id="mobile" value="{{ old('mobile') }}" required>
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/mobile-->

                    <!--email-->
                    <div class="form-group">
                        <label for="email"><span class="text-danger">*</span>Email address</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ old('email') }}" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/email-->

                    <!--password-->
                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span>Password</label>
                        <input name="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--password-->

                    <button type="submit" class="btn btn-dark">Submit</button>

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

<script type="text/javascript">
    function showAccountTypeOption(account_type)
    {
        let url = "/admin/options-for-account-type?account_type=" + account_type;
        $.get( url, function( data ) {
            $("#account_type_option").html(data);
        });

    }

    $(document).ready(function () {

        $('#quickForm').validate({
            onkeyup: false,
            rules: {

                name: {
                    required: true
                },

                mobile: {
                    required: true,
                    minlength: 11
                },

                email: {
                    required: true,
                    email: true
                },

                password: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {

                name: {
                    required: "Please enter Name"
                },

                mobile: {
                    required: "Please enter Mobile Number",
                    email: "Please enter a vaild mobile number"
                },

                email: {
                    required: "Please enter a email address",
                    email: "Please enter a vaild email address"
                },

                password: {
                    required: "Please provide a password",
                    minlength: "password must be at least 8 characters long"
                }
            },

            errorElement: 'span',

            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },

            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }

        });
    });

</script>

@endsection
