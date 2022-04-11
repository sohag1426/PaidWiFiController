@extends ('laraview.layouts.sideNavLayout')

@section('title')
Master Package edit
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
Edit Master Package
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST"
            action="{{ route('master_packages.update', ['master_package' => $master_package->id]) }}">

            @csrf

            @method('PUT')

            <div class="col-sm-6">

                @if ($master_package->connection_type == 'PPPoE')
                <!--pppoe_profile_id-->
                <div class="form-group">
                    <label for="pppoe_profile">PPP Profile</label>
                    <input type="text" class="form-control" id="pppoe_profile"
                        value="{{ $master_package->pppoe_profile->name }} ::  {{ long2ip($master_package->pppoe_profile->ipv4pool->subnet).'/'. $master_package->pppoe_profile->ipv4pool->mask }} :: {{ $master_package->pppoe_profile->ipv6pool->prefix }}"
                        disabled>
                </div>
                <!--/pppoe_profile_id-->
                @endif

                <!--name-->
                @if (Auth::user()->can('updateName', $master_package))
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>Name</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $master_package->name }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                @else
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $master_package->name }}" disabled>
                </div>
                @endif
                <!--/name-->

                <!--rate_limit-->
                @if ($master_package->connection_type !== 'StaticIp')
                <div class="form-group">
                    <label for="rate_limit"><span class="text-danger">*</span>Speed Limit</label>

                    <div class="input-group">
                        <input name="rate_limit" type="number"
                            class="form-control @error('rate_limit') is-invalid @enderror" id="rate_limit"
                            aria-describedby="rateLimitHelp" value="{{ $master_package->rate_limit }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <select name="rate_unit" id="rate_unit" class="select2" required>
                                    <option value="{{ $master_package->rate_unit }}">
                                        {{ $master_package->readable_rate_unit }}</option>
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
                @endif
                <!--/rate_limit-->

                <!--speed_controller-->
                @if ($master_package->connection_type !== 'StaticIp')
                <div class="form-group">
                    <label for="speed_controller"><span class="text-danger">*</span>Speed Controller</label>

                    <div class="input-group">

                        <select class="form-control" id="speed_controller" name="speed_controller"
                            aria-describedby="speedControllerHelp" required>
                            <option selected>{{ $master_package->speed_controller }}</option>
                            <option>Router</option>
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
                @endif
                <!--/speed_controller-->

                <!--volume_limit-->
                @if ($master_package->connection_type !== 'StaticIp')
                <div class="form-group">
                    <label for="volume_limit"><span class="text-danger">*</span>Volume Limit</label>

                    <div class="input-group">
                        <input name="volume_limit" type="number"
                            class="form-control @error('volume_limit') is-invalid @enderror" id="volume_limit"
                            aria-describedby="mbLimitHelp" value="{{ $master_package->volume_limit }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <select name="volume_unit" id="volume_unit" class="select2" required>
                                    <option value="{{ $master_package->volume_unit }}">{{ $master_package->volume_unit
                                        }}
                                    </option>
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
                @endif
                <!--/volume_limit-->

                <!--validity-->
                <div class="form-group">
                    <label for="validity"><span class="text-danger">*</span>Validity</label>

                    <div class="input-group">
                        <input name="validity" type="number"
                            class="form-control @error('validity') is-invalid @enderror" id="validity"
                            value="{{ $master_package->validity }}" required>
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

        onkeyup: false,

        rules: {

          name: {
            required: true,
            maxlength: 128
          },

          rate_limit: {
            required: true,
            number: true
          },

          validity: {
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

          validity: {
            required: "Please enter validity",
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
