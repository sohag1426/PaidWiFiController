@section('contentTitle')
<h3>Edit Router</h3>
@endsection

@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form id="quickForm" method="POST" action="{{ route('routers.update', ['router' => $router->id]) }}" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="card-body">

            <!--location-->
            <div class="form-group">
                <label for="location"><span class="text-danger">*</span>Location</label>
                <input name="location" type="text" class="form-control @error('location') is-invalid @enderror"
                    id="location" value="{{ $router->location }}" required>
                @error('location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/location-->

            <!--nasname-->
            <div class="form-group">
                <label for="nasname"><span class="text-danger">*</span>IP Address</label>
                <input name="nasname" type="text" class="form-control @error('nasname') is-invalid @enderror"
                    id="nasname" value="{{ $router->nasname }}" required>
                @error('nasname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/nasname-->

            <!--api_port-->
            <div class="form-group">
                <label for="api_port"><span class="text-danger">*</span>API Port</label>
                <input name="api_port" type="text" class="form-control @error('api_port') is-invalid @enderror"
                    id="api_port" value="{{ $router->api_port }}" required>
                @error('api_port')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/api_port-->

            <!--api_username-->
            <div class="form-group">
                <label for="api_username"><span class="text-danger">*</span>API User</label>
                <input name="api_username" type="text" class="form-control @error('api_username') is-invalid @enderror"
                    id="api_username" value="{{ $router->api_username }}" required>
                @error('api_username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/api_username-->

            <!--api_password-->
            <div class="form-group">
                <label for="api_password"><span class="text-danger">*</span>API Password</label>
                <input name="api_password" type="password"
                    class="form-control @error('api_password') is-invalid @enderror" id="api_password"
                    value="{{ $router->api_password }}" required>
                @error('api_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--api_password-->

            <!--overwrite_comment-->
            <div class="form-group">
                <label for="overwrite_comment"><span class="text-danger">*</span>Overwrite PPP Secrets Comment</label>
                <select class="form-control" id="overwrite_comment" name="overwrite_comment" required>
                    <option selected>{{ $router->overwrite_comment }}</option>
                    <option value="yes">yes</option>
                    <option value="no">no</option>
                </select>
                @error('overwrite_comment')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/overwrite_comment-->

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')

<script type="text/javascript">
    $(document).ready(function () {

      $('#quickForm').validate({
        onkeyup: true,
        rules: {

          location: {
            required: true,
            maxlength: 128
          },

          nasname: {
            required: true
          },

          api_port: {
            required: true
          },

          api_username: {
            required: true,
            alphanumeric: true
          },

          api_password: {
            required: true,
            minlength: 8
          }
        },
        messages: {

          location: {
            required: "Please enter location of your router"
          },

          nasname: {
            required: "Please enter IPv4 Address of your router"
          },

          api_port: {
            required: "Please enter api port number",
          },

          api_username: {
            required: "Please enter api user",
          },

          api_password: {
            required: "Please provide a password",
            minlength: "API password must be at least 8 characters long"
          },

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
