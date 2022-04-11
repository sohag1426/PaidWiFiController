@extends ('laraview.layouts.sideNavLayout')

@section('title')
Create Package
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '2';
$active_link = '6';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')
<h3> New Package </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST"
            action="{{ route('temp_packages.master_packages.store', ['temp_package' => $temp_package->id]) }}">

            @csrf

            <div class="col-sm-6">

                <!--name-->
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>Name</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ old('name') }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/name-->

                <!--rate_limit-->
                <div class="form-group">
                    <label for="rate_limit"><span class="text-danger">*</span>Speed Limit</label>

                    <div class="input-group">
                        <input name="rate_limit" type="number"
                            class="form-control @error('rate_limit') is-invalid @enderror" id="rate_limit"
                            aria-describedby="rateLimitHelp" value="{{ old('rate_limit') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <select name="rate_unit" id="rate_unit" class="select2" required>
                                    <option value="M">Mbps</option>
                                    <option value="k">Kbps</option>
                                </select>
                            </span>
                        </div>
                    </div>

                    <small id="rateLimitHelp" class="form-text text-muted">Please enter 0(zero) for unlimited
                        speed.</small>

                    @error('rate_limit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/rate_limit-->

                <!--speed_controller-->
                <div class="form-group">
                    <label for="speed_controller"><span class="text-danger">*</span>Speed Controller</label>

                    <div class="input-group">

                        <select class="form-control" id="speed_controller" name="speed_controller"
                            aria-describedby="speedControllerHelp" required>
                            <option selected>Router</option>
                            <option>Radius_Server</option>
                        </select>

                    </div>

                    <small id="speedControllerHelp" class="form-text text-muted">Which one will set speed limit.</small>

                    @error('speed_controller')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/speed_controller-->

                <!--volume_limit-->
                <div class="form-group">
                    <label for="volume_limit"><span class="text-danger">*</span>Volume Limit</label>

                    <div class="input-group">
                        <input name="volume_limit" type="number"
                            class="form-control @error('volume_limit') is-invalid @enderror" id="volume_limit"
                            aria-describedby="mbLimitHelp" value="{{ old('volume_limit') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <select name="volume_unit" id="volume_unit" class="select2" required>
                                    <option value="GB">GB</option>
                                    <option value="MB">MB</option>
                                </select>
                            </span>
                        </div>
                    </div>

                    <small id="mbLimitHelp" class="form-text text-muted">Please enter 0(zero) for unlimited
                        volume.</small>

                    @error('volume_limit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/volume_limit-->

                <!--validity-->
                <div class="form-group">
                    <label for="validity"><span class="text-danger">*</span>Validity</label>

                    <div class="input-group">
                        <input name="validity" type="number"
                            class="form-control @error('validity') is-invalid @enderror" id="validity" value="30"
                            required>
                        <div class="input-group-append">
                            <span class="input-group-text">Days</span>
                        </div>
                    </div>

                    @error('validity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/validity-->

            </div>
            <!--/col-sm-6-->

            <div class="col-sm-6">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>

        </form>

    </div>

</div>

@endsection

@section('pageJs')


<script type="text/javascript">
    $(document).ready(function () {

      $('#quickForm').validate({

        onkeyup: true,

        rules: {

          name: {
            required: true,
            maxlength: 128
          },

          rate_limit: {
            required: true,
            number: true
          },

          volume_limit: {
            required: true,
            number: true
          },

          volume_unit: {
            required: true
          }

        },

        messages: {

          name: {
            required: "Please enter Package Name"
          },

          rate_limit: {
            required: "Please enter speed limit"
          },

          volume_limit: {
            required: "Please enter volume limit",
          },

          volume_unit: {
            required: "Please select volume unit",
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
