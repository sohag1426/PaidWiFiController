@section('contentTitle')

{{-- @Filter --}}
<form class="d-flex align-content-start flex-wrap" action="{{ route('online_customers.index') }}" method="get">

    {{-- connection_type --}}
    <div class="form-group col-md-2">
        <select name="connection_type" id="connection_type" class="form-control">
            <option value=''>connection type...</option>
            <option value='PPPoE'>PPP</option>
            <option value='Hotspot'>Hotspot</option>
        </select>
    </div>
    {{--connection_type --}}

    {{-- status --}}
    <div class="form-group col-md-2">
        <select name="status" id="status" class="form-control">
            <option value=''>status...</option>
            <option value='active'>active</option>
            <option value='suspended'>suspended</option>
            <option value='disabled'>disabled</option>
        </select>
    </div>
    {{--status --}}

    {{-- payment_status --}}
    <div class="form-group col-md-2">
        <select name="payment_status" id="payment_status" class="form-control">
            <option value=''>payment status...</option>
            <option value='billed'>billed</option>
            <option value='paid'>paid</option>
        </select>
    </div>
    {{--payment_status --}}

    {{-- zone_id --}}
    <div class="form-group col-md-2">
        <select name="zone_id" id="zone_id" class="form-control">
            <option value=''>zone...</option>
            @foreach (Auth::user()->customer_zones->sortBy('name') as $customer_zone)
            <option value="{{ $customer_zone->id }}">{{ $customer_zone->name }}</option>
            @endforeach
        </select>
    </div>
    {{--zone_id --}}

    {{-- device_id --}}
    <div class="form-group col-md-2">
        <select name="device_id" id="device_id" class="form-control">
            <option value=''>device...</option>
            @foreach (Auth::user()->devices->sortBy('name') as $device)
            <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->location }})</option>
            @endforeach
        </select>
    </div>
    {{--device_id --}}

    {{-- package_id --}}
    <div class="form-group col-md-2">
        <select name="package_id" id="package_id" class="form-control">
            <option value=''>package...</option>
            @foreach (Auth::user()->assigned_packages->sortBy('name') as $package)
            <option value="{{ $package->id }}">{{ $package->name }}</option>
            @endforeach
        </select>
    </div>
    {{--package_id --}}

    {{-- sortby --}}
    <div class="form-group col-md-2">
        <select name="sortby" id="sortby" class="form-control">
            <option value=''>Sort By...</option>
            <option value="username">Username</option>
            <option value="bandwidth_usage">Bandwidth Usage</option>
        </select>
    </div>
    {{-- sortby --}}

    {{-- Page length --}}
    <div class="form-group col-md-2">
        <select name="length" id="length" class="form-control">
            <option value="{{ $length }}" selected>Show {{ $length }} entries </option>
            <option value="10">Show 10 entries</option>
            <option value="25">Show 25 entries</option>
            <option value="50">Show 50 entries</option>
            <option value="100">Show 100 entries</option>
        </select>
    </div>
    {{--Page length --}}

    {{-- username --}}
    <div class="form-group col-md-2">
        <input type="text" name="username" id="username" class="form-control" placeholder="username LIKE ...">
    </div>
    {{-- username --}}

    @if (Auth::user()->role == 'group_admin')
    {{-- operator --}}
    <div class="form-group col-md-2">
        <select name="operator_id" id="operator_id" class="form-control">
            <option value=''>operator...</option>
            @foreach (Auth::user()->operators->where('role', '!=', 'manager') as $operator)
            <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
            @endforeach
        </select>
    </div>
    {{--operator --}}
    @endif

    <div class="form-group col-md-1">
        <button type="submit" class="btn btn-dark">FILTER</button>
    </div>

</form>
{{-- @endFilter --}}

@endsection

@section('content')

<div class="card">

    <!--modal -->
    <div class="modal fade" id="modal-customer">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ModalBody">

                    <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                    <div class="text-bold pt-2">Loading...</div>
                    <div class="text-bold pt-2">Please Wait</div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal -->


    <!--traffic modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-traffic">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">
                        <span class="text-danger border border-danger">
                            LIVE
                        </span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="showOff()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="show_id" value="">

                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="font-weight-bold">Name: </span>
                            <span id="live_name"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Username: </span>
                            <span id="live_username"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Package Name: </span>
                            <span id="live_package"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Status: </span>
                            <span id="live_status"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold text-success">Download (Kbps): </span>
                            <span id="live_download"></span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold text-primary">Upload (Kbps): </span>
                            <span id="live_upload"></span>
                        </li>
                    </ul>
                    <canvas id="smoothie-chart" width="470" height="200">
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="showOff()">Close</button>
                </div>

            </div>

        </div>

    </div>
    <!-- /traffic modal -->


    <div class="card-body">

        {{-- Realtime Search --}}
        <nav class="navbar justify-content-end">
            <form class="form-inline">
                {{-- mobile_serach --}}
                <input class="form-control mr-sm-2" id="mobile_serach" type="search" placeholder="Search Mobile.."
                    onchange="serachOnlineCustomer(this.value)">
                {{-- mobile_serach --}}

                {{-- username_serach --}}
                <input class="form-control mr-sm-2" id="username_serach" type="search" placeholder="Search username.."
                    onchange="serachOnlineCustomerUsername(this.value)">
                {{-- username_serach --}}
            </form>
        </nav>
        {{-- Realtime Search --}}

        <div id='search_result'></div>

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">MAC Addresses</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Download</th>
                    <th scope="col">Upload</th>
                    <th scope="col">UP Time</th>
                    <th scope="col">Updated At</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($radaccts as $radacct )
                <tr>
                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $radacct->customer->id }}')">
                            {{ $radacct->username }}
                        </a>
                    </td>
                    <td>{{ $radacct->callingstationid }}</td>
                    <td>{{ $radacct->framedipaddress }}</td>
                    <td>{{ $radacct->acctoutputoctets/1000/1000/1000 }} GB</td>
                    <td>{{ $radacct->acctinputoctets/1000/1000/1000 }} GB</td>
                    <td>{{ sToHms($radacct->acctsessiontime) }}</td>
                    <td>{{ $radacct->acctupdatetime }}</td>
                    <td>
                        {{-- Live Traffic --}}
                        @if ($radacct->customer->connection_type == "PPPoE")
                        <a href="#"
                            onclick="monitorTraffic('{{ route('interface-traffic.show', ['radacct' => $radacct->id]) }}')">
                            <i class="fas fa-chart-area"></i> Traffic
                        </a>
                        @endif
                        {{-- Live Traffic --}}
                        {{-- MAC Bind --}}
                        @if ($radacct->customer->mac_bind == "0")
                        <a href="{{ route('mac-bind-create', ['radacct' => $radacct->id]) }}">
                            <i class="fas fa-user-lock"></i> MAC Bind
                        </a>
                        @endif
                        {{-- MAC Bind --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Entries: {{ $radaccts->total() }}
            </div>
            <div class="col-sm-6">
                {{ $radaccts->withQueryString()->links() }}
            </div>
            <div class="col-sm-2 ml-2">
                {{-- <a class="btn btn-outline-danger" href="{{ route('delete-stale-sessions') }}">Delete Stales</a>
                --}}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')

<script src="/jsPlugins/smoothie.js"></script>

<script>
    $(document).ready(function () {

        $.ajax({
            url: "/admin/customer-mobiles"
        }).done(function (result) {
            let mobiles = jQuery.parseJSON(result);
            $("#mobile_serach").autocomplete({
                source: mobiles,
                autoFocus: true
            });
        });

        $.ajax({
            url: "/admin/customer-usernames"
        }).done(function (result) {
            let usernames = jQuery.parseJSON(result);
            $("#username_serach").autocomplete({
                source: usernames,
                autoFocus: true
            });
        });

    });

    function serachOnlineCustomer(online_customer) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (online_customer.length > 1) {
            $.ajax({
                url: "/admin/online_customers/mobile?mobile=" + online_customer
            }).done(function (data) {
                $("#search_result").html(data);
            });
        } else {
            $("#search_result").html("");
        }
    }

    function serachOnlineCustomerUsername(customer_username) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (customer_username.length > 1) {
            $.ajax({
                url: "/admin/online_customers/username?username=" + customer_username
            }).done(function (data) {
                $("#search_result").html(data);
            });
        } else {
            $("#search_result").html("");
        }
    }

    function showCustomerDetails(customer)
    {
        $("#modal-title").html("Customer Details");
        $("#ModalBody").html('<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Loading...</div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Please Wait</div>');
        $('#modal-customer').modal('show');
        $.get( "/admin/customer-details/" + customer, function( data ) {
            $("#ModalBody").html(data);
        });
    }

    function showOff() {
        let interval_id = $('#show_id').val();
        if (interval_id.length) {
            clearInterval(interval_id);
            $('#show_id').val("");
        }
    }

    function monitorTraffic(show_url) {

        $('#modal-traffic').modal('show');

        var smoothie = new SmoothieChart({
            grid:{fillStyle:'#e8cece'},
            labels:{
                fillStyle:'#f40101',
                fontSize:20,
                precision:5
            }
        });

        smoothie.streamTo(document.getElementById("smoothie-chart"));

        var smoothie_download = new TimeSeries();

        var smoothie_upload = new TimeSeries();

        let interval_id = setInterval(function() {

            $.ajax({
                url: show_url
            }).done(function(data) {

                var json_obj = jQuery.parseJSON(data);

                // console.log(json_obj);

                // console.log("interval id : " + interval_id);

                var name = json_obj.name;
                $('#live_name').html(name);

                var username = json_obj.username;
                $('#live_username').html(username);

                var package_name = json_obj.package_name;
                $('#live_package').html(package_name);

                var status = json_obj.status;
                $('#live_status').html(status);

                var upload_kbps = parseInt(json_obj.upload);
                $('#live_upload').html(upload_kbps);
                smoothie_upload.append(Date.now(), upload_kbps);

                var download_kbps = parseInt(json_obj.download);
                $('#live_download').html(download_kbps);
                smoothie_download.append(Date.now(), download_kbps);

                if(status != "Online"){
                    showOff();
                }

            }).fail(function() {
                showOff();
            });

        }, 3000);

        $('#show_id').val(interval_id);

        smoothie.addTimeSeries(smoothie_download, {lineWidth:2,strokeStyle:'#007E33'});
        smoothie.addTimeSeries(smoothie_upload, {lineWidth:2,strokeStyle:'#0d47a1'});

    }

</script>

@endsection
