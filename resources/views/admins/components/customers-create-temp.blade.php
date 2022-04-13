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
                            <option value="Hotspot">Hotspot</option>
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
    function checkDuplicateMobile(mobile)
    {
        let url = "/admin/check-customers-uniqueness?attribute=mobile&value=" + mobile;
        $.get( url, function( data ) {
            $("#duplicate_mobile_response").html(data);
        });
    }

</script>

@endsection
