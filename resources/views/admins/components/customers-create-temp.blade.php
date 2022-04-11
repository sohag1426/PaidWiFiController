@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">

                <form method="POST" action="{{ route('temp_customers.store') }}" onsubmit="return showWait()">

                    @csrf

                    <!--connection_type-->
                    <div class="form-group">
                        <label for="connection_type"><span class="text-danger">*</span>Connection Type</label>
                        <select class="form-control" id="connection_type" name="connection_type" required>
                            <option value="">Please select...</option>
                            <option value="PPPoE">PPPoE</option>
                            <option value="Hotspot">Hotspot</option>
                            @if (Auth::user()->role == 'group_admin')
                            <option value="StaticIp">Static IP</option>
                            @endif
                        </select>
                    </div>
                    <!--/connection_type-->

                    <!--name-->
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span>Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name') }}" autocomplete="name" required>
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
                            id="mobile" value="{{ old('mobile') }}" onblur="checkDuplicateMobile(this.value)" required>
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div id="duplicate_mobile_response"></div>

                    </div>
                    <!--/mobile-->

                    <!--nid-->
                    <div class="form-group">
                        <label for="nid">NID Number</label>
                        <input name="nid" type="nid" class="form-control @error('nid') is-invalid @enderror" id="nid"
                            value="{{ old('nid') }}" autocomplete="nid">
                        @error('nid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/nid-->

                    <!-- date_of_birth -->
                    <div class="form-group">

                        <label for="date_of_birth">Date Of Birth</label>
                        <input type="text" id="date_of_birth" name="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask>

                        @error('date_of_birth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <!-- /date_of_birth -->

                    <!--zone_id-->
                    <div class="form-group">
                        <label for="zone_id">Customer Zone</label>
                        <select class="form-control" id="zone_id" name="zone_id">
                            <option value="">Please select...</option>
                            @foreach ($customer_zones as $customer_zone)
                            <option value="{{ $customer_zone->id }}">{{ $customer_zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/zone_id-->

                    <!--device_id-->
                    <div class="form-group">
                        <label for="device_id">Device</label>
                        <select class="form-control" id="device_id" name="device_id">
                            <option value="">Please select...</option>
                            @foreach ($devices as $device)
                            <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->location }})</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/device_id-->

                    <!--email-->
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ old('email') }}" autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/email-->

                    <button type="submit" class="btn btn-dark">NEXT<i class="fas fa-arrow-right"></i></button>

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

<script>
    //Initialize Select2 Elements
      $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
    theme: 'bootstrap4'
    });

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
    $('[data-mask]').inputmask();

    function checkDuplicateMobile(mobile)
    {
        let url = "/admin/check-customers-uniqueness?attribute=mobile&value=" + mobile;
        $.get( url, function( data ) {
            $("#duplicate_mobile_response").html(data);
        });
    }

</script>

@endsection
