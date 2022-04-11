@section('contentTitle')
<h3> Edit customer </h3>
@endsection

@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form id="quickForm" method="POST"
        action="{{ route('customers.update', ['customer' => $customer->id, 'page' => $page]) }}"
        onsubmit="return showWait()">

        <div class="card-body">

            <div class="row">

                <div class="col-sm-6">

                    @csrf

                    @method('put')

                    <!--zone_id-->
                    <div class="form-group">
                        <label for="zone_id">Customer Zone</label>
                        <select class="form-control" id="zone_id" name="zone_id">
                            <option value="{{ $customer->zone_id }}" selected>{{ $customer->zone }}</option>
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
                            <option value="{{ $customer->device_id }}" selected>{{ $customer->device }}</option>
                            @foreach ($devices as $device)
                            <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->location }})</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/device_id-->

                    <!--name-->
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span>Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ $customer->name }}" required>
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
                            id="mobile" value="{{ $customer->mobile }}" onblur="checkDuplicateMobile(this.value)"
                            required>
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div id="duplicate_mobile_response"></div>

                    </div>
                    <!--/mobile-->


                    <!--email-->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="text" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ $customer->email }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/email-->

                    <!--billing_profile_id-->
                    @can('editBillingProfile', $customer)
                    <div class="form-group">
                        <label for="billing_profile_id"><span class="text-danger">*</span>Billing Profile</label>
                        <select class="form-control" id="billing_profile_id" name="billing_profile_id" required>
                            <option value="{{ $customer->billing_profile_id }}" selected>{{ $customer->billing_profile
                                }}
                            </option>
                            @foreach ($billing_profiles->sortBy('name') as $billing_profile)
                            <option value="{{ $billing_profile->id }}">{{ $billing_profile->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endcan
                    <!--/billing_profile_id-->

                </div>
                <!--/col-sm-6-->

                <div class="col-sm-6">

                    <!--username-->
                    <div class="form-group">
                        <label for="username"><span class="text-danger">*</span>username</label>
                        <input name="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            id="username" value="{{ $customer->username }}" autocomplete="username"
                            onblur="checkDuplicateUsername(this.value)" required>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div id="duplicate_username_response"></div>

                    </div>
                    <!--/username-->

                    <!--password-->
                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span>password</label>
                        <input name="password" type="text" class="form-control @error('password') is-invalid @enderror"
                            id="password" value="{{ $customer->password }}" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/password-->

                    @if ($customer->connection_type === 'StaticIp')

                    <!--router_id-->
                    <div class="form-group">
                        <label for="router_id"><span class="text-danger">*</span>Router</label>

                        <select class="form-control" id="router_id" name="router_id" required>

                            <option value="{{ $customer->router_id }}" selected>{{ $customer->router->nasname }}
                            </option>

                            @foreach ($routers as $router)
                            <option value="{{ $router->id }}">{{ $router->location }} :: {{ $router->nasname }}
                            </option>
                            @endforeach

                        </select>

                        @error('router_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/router_id-->

                    <!--login_ip-->
                    <div class="form-group">
                        <label for="login_ip"><span class="text-danger">*</span>IP Address</label>
                        <input name="login_ip" type="text" class="form-control @error('login_ip') is-invalid @enderror"
                            id="login_ip" value="{{ $customer->login_ip }}" required>

                        @error('login_ip')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <!--/login_ip-->

                    @endif

                    <!--house_no-->
                    <div class="form-group">
                        <label for="house_no">House#</label>
                        <input name="house_no" type="text" class="form-control @error('house_no') is-invalid @enderror"
                            id="house_no" value="{{ $customer->house_no }}">
                        @error('house_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/house_no-->

                    <!--road_no-->
                    <div class="form-group">
                        <label for="road_no">Road#</label>
                        <input name="road_no" type="text" class="form-control @error('road_no') is-invalid @enderror"
                            id="road_no" value="{{ $customer->road_no }}">
                        @error('road_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/road_no-->

                    <!--thana-->
                    <div class="form-group">
                        <label for="thana">Thana</label>
                        <input name="thana" type="text" class="form-control @error('thana') is-invalid @enderror"
                            id="thana" value="{{ $customer->thana }}">
                        @error('thana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/thana-->

                    <!--district-->
                    <div class="form-group">
                        <label for="district">District</label>
                        <input name="district" type="text" class="form-control @error('district') is-invalid @enderror"
                            id="district" value="{{ $customer->district }}">
                        @error('district')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/district-->

                </div>
                <!--/col-sm-6-->

            </div>
            <!--/row-->

            {{-- custom fields --}}
            <div class="row">
                @foreach ($custom_fields as $custom_field)
                <div class="col">
                    <div class="form-group">
                        <label for="{{ $custom_field->id }}">{{ $custom_field->name }}</label>
                        <input name="{{ $custom_field->id }}" type="text" class="form-control"
                            id="{{ $custom_field->id }}" value="{{ $custom_field->value }}">
                    </div>
                </div>
                @endforeach
            </div>
            {{-- custom fields --}}

            {{-- comment --}}
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <input type="text" name="comment" class="form-control" id="comment"
                            value="{{ $customer->comment }}">
                    </div>
                </div>
            </div>
            {{-- comment --}}

        </div>
        <!--/card-body-->


        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Submit</button>
        </div>
        <!--/card-footer-->

    </form>

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

    function checkDuplicateUsername(username)
    {
        let url = "/admin/check-customers-uniqueness?attribute=username&value=" + username;
        $.get( url, function( data ) {
            $("#duplicate_username_response").html(data);
        });
    }

</script>
@endsection
