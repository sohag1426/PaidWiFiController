@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form id="quickForm" method="POST" action="{{ route('routers.store') }}" autocomplete="off">
        @csrf

        <div class="card-body">

            <div class="row">

                <div class="col-sm">

                    <!--location-->
                    <div class="form-group">
                        <label for="location"><span class="text-danger">*</span>Location</label>
                        <input name="location" type="text" class="form-control @error('location') is-invalid @enderror"
                            id="location" value="{{ old('location') }}" required>
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
                            id="nasname" value="{{ old('nasname') }}" required>
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
                            id="api_port" value="{{ old('api_port') }}" required>
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
                        <input name="api_username" type="text"
                            class="form-control @error('api_username') is-invalid @enderror" id="api_username"
                            value="{{ old('api_username') }}" required>
                        @error('api_username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/api_username-->

                    <!--api_password-->
                    <div class="form-group">
                        <label for="api_password"><span class="text-danger">*</span>API User's Password</label>
                        <input name="api_password" type="password"
                            class="form-control @error('api_password') is-invalid @enderror" id="api_password"
                            placeholder="api password" required>
                        @error('api_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--api_password-->

                </div>

                {{-- /Left Column --}}

                <div class="col-sm">

                    @if (config('consumer.country_code') == "BD")

                    <dl>
                        {{-- Location --}}
                        <dt><span class="text-danger">Location</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    এখানে রাউটার এর লোকেশন লিখুন, যাতে পরবর্তীতে রাউটারটি সহজে চিহ্নিত করতে পারেন।
                                </li>
                            </ul>
                        </dd>
                        {{-- Location --}}
                        <hr>
                        {{-- IP Address --}}
                        <dt><span class="text-danger">IP Address</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    এখানে রাউটার এর একটি পাবলিক / রিয়েল আইপি লিখুন ।
                                </li>
                            </ul>
                        </dd>
                        {{-- IP Address --}}
                        <hr>
                        {{-- API Port--}}
                        <dt><span class="text-danger">API Port</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    এখানে রাউটার এর API Port নাম্বার লিখুন ।
                                </li>
                                <li>
                                    API Port নাম্বার দেখতে WinBox ওপেন করে IP->Services এ ক্লিক করুন।
                                </li>
                            </ul>
                        </dd>
                        {{-- API Port --}}
                        <hr>
                        {{-- API User--}}
                        <dt><span class="text-danger">API User</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    API User হচ্ছে আপনার মাইক্রোটিক রাউটার এর সিস্টেম ইউসার।
                                </li>
                                <li>
                                    User List দেখতে WinBox ওপেন করে System->Users এ ক্লিক করুন।
                                </li>
                                <li>
                                    Mikrotik থেকে Billing Software এ কাস্টমারগুলো Import করার জন্য API User কে ফুল
                                    পারমিশন
                                    দিতে হবে।
                                </li>
                            </ul>
                        </dd>
                        {{-- API User --}}
                        <hr>
                        {{-- API User's Password --}}
                        <dt><span class="text-danger">API User's Password</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    এখানে API User এর Password লিখুন ।
                                </li>
                            </ul>
                        </dd>
                        {{-- API User's Password --}}

                    </dl>

                    @else

                    <dl>
                        {{-- Location --}}
                        <dt><span class="text-danger">Location</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    This is just a Tag, so that you can identify the router later easily.
                                </li>
                            </ul>
                        </dd>
                        {{-- Location --}}
                        <hr>
                        {{-- IP Address --}}
                        <dt><span class="text-danger">IP Address</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    Here, write one of the public IP address of your router.
                                </li>
                            </ul>
                        </dd>
                        {{-- IP Address --}}
                        <hr>
                        {{-- API Port--}}
                        <dt><span class="text-danger">API Port</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    Here, Write your MikroTik Router's API port number.
                                </li>
                                <li>
                                    To see the API Port number, open WinBox, then click on IP->Services.
                                </li>
                            </ul>
                        </dd>
                        {{-- API Port --}}
                        <hr>
                        {{-- API User--}}
                        <dt><span class="text-danger">API User</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    API User is the system user of your MikroTik Router.
                                </li>
                                <li>
                                    To see User List, Open WinBox, then click on System->Users.
                                </li>
                                <li>
                                    To Import Customers from Mikrotik Router to Billing Software, you have to give full
                                    permission to the API user.
                                </li>
                            </ul>
                        </dd>
                        {{-- API User --}}
                        <hr>
                        {{-- API User's Password --}}
                        <dt><span class="text-danger">API User's Password</span></dt>
                        <dd>
                            <ul>
                                <li>
                                    Write API User's Password here.
                                </li>
                            </ul>
                        </dd>
                        {{-- API User's Password --}}

                    </dl>

                    @endif

                </div>
                {{-- Right Columns --}}

            </div>
            {{-- /row --}}

        </div>
        {{-- Card Body --}}

        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Submit</button>
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
