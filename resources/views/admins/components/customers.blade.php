@section('contentTitle')

{{-- @Filter --}}
<form class="d-flex align-content-start flex-wrap" action="{{ route('customers.index') }}" method="get">

    {{-- connection_type --}}
    <div class="form-group col-md-2">
        <select name="connection_type" id="connection_type" class="form-control">
            <option value=''>connection type...</option>
            <option value='PPPoE'>PPP</option>
            <option value='Hotspot'>Hotspot</option>
            <option value='StaticIp'>StaticIp</option>
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
            @foreach (Auth::user()->allPackages->groupBy('operator_id') as $gpackages)
            @foreach ($gpackages->sortBy('name') as $package)
            <option value="{{ $package->id }}">{{ $package->operator->name }} :: {{ $package->name }}</option>
            @endforeach
            @endforeach
        </select>
    </div>
    {{--package_id --}}

    {{-- billing_profile_id --}}
    <div class="form-group col-md-2">
        <select name="billing_profile_id" id="billing_profile_id" class="form-control">
            <option value=''>Billing Profile...</option>
            @foreach (Auth::user()->billing_profiles->sortBy('name') as $billing_profile)
            <option value="{{ $billing_profile->id }}">{{ $billing_profile->name }}</option>
            @endforeach
        </select>
    </div>
    {{--billing_profile_id --}}

    {{-- ip --}}
    <div class="form-group col-md-2">
        <input type="text" name="ip" id="ip" class="form-control" placeholder="IP Address"
            data-inputmask="'alias': 'ip'" data-mask>
    </div>
    {{-- ip --}}

    {{-- mac_bind --}}
    <div class="form-group col-md-2">
        <select name="mac_bind" id="mac_bind" class="form-control">
            <option value=''>mac bind...</option>
            <option value='0'>False</option>
            <option value='1'>True</option>
        </select>
    </div>
    {{--mac_bind --}}

    {{-- advance_payment --}}
    <div class="form-group col-md-2">
        <select name="advance_payment" id="advance_payment" class="form-control">
            <option value=''>advance payment...</option>
            <option value='0'>No</option>
            <option value='1'>Yes</option>
        </select>
    </div>
    {{--advance_payment --}}

    {{-- year --}}
    <div class="form-group col-md-2">
        <select name="year" id="year" class="form-control">
            <option value=''>Reg. year...</option>
            @php
            $start = date(config('app.year_format'));
            $stop = $start - 5;
            @endphp
            @for($i = $start; $i >= $stop; $i--)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>
    {{--year --}}

    {{-- month --}}
    <div class="form-group col-md-2">
        <select name="month" id="month" class="form-control">
            <option value=''>Reg. month...</option>
            <option value='January'>January</option>
            <option value='February'>February</option>
            <option value='March'>March</option>
            <option value='April'>April</option>
            <option value='May'>May</option>
            <option value='June'>June</option>
            <option value='July'>July</option>
            <option value='August'>August</option>
            <option value='September'>September</option>
            <option value='October'>October</option>
            <option value='November'>November</option>
            <option value='December'>December</option>
        </select>
    </div>
    {{--month --}}

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

    {{-- sortby --}}
    <div class="form-group col-md-2">
        <select name="sortby" id="sortby" class="form-control">
            <option value=''>Sort By...</option>
            <option value="id">Customer ID</option>
            <option value="username">Username</option>
        </select>
    </div>
    {{-- sortby --}}

    {{-- username --}}
    <div class="form-group col-md-2">
        <input type="text" name="username" id="username" class="form-control" placeholder="username LIKE ...">
    </div>
    {{-- username --}}

    {{-- comment --}}
    <div class="form-group col-md-2">
        <input type="text" name="comment" id="comment" class="form-control" placeholder="comment LIKE ...">
    </div>
    {{-- comment --}}

    {{-- operator --}}
    @if (Auth::user()->role == 'group_admin' || Auth::user()->role == 'operator')
    <div class="form-group col-md-2">
        <select name="operator_id" id="operator_id" class="form-control">
            <option value=''>operator...</option>
            @foreach (Auth::user()->operators->where('role', '!=', 'manager') as $operator)
            <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
            @endforeach
        </select>
    </div>
    @endif
    {{--operator --}}

    <div class="form-group col-md-2">
        <button type="submit" class="btn btn-dark">FILTER</button>
    </div>

</form>

{{-- @endFilter --}}

{{-- Download & Upload --}}

<ul class="nav justify-content-end">

    <li class="nav-item">
        @if (url()->current() == url()->full())
        <a class="nav-link text-danger" href="{{ url()->full() . '?refresh=1' }}">
            <i class="fas fa-retweet"></i> Refresh
        </a>
        @else
        <a class="nav-link text-danger" href="{{ url()->full() . '&refresh=1' }}">
            <i class="fas fa-retweet"></i> Refresh
        </a>
        @endif
    </li>

    @if (Auth::user()->role == 'group_admin' || Auth::user()->role == 'operator')

    <li class="nav-item">
        <a class="nav-link" href="{{ route('download-users-downloadable.create') }}">
            <i class="fas fa-download"></i> Download users
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('bulk-update-users.create') }}">
            <i class="fas fa-upload"></i> Bulk update users
        </a>
    </li>

    @endif

</ul>

{{-- Download & Upload --}}

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

    {{-- modal-delete --}}
    <div class="modal" id="modal-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Please Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="POST" id="delete-form">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal-delete --}}

    <!-- Modal Activate Options -->
    <div class="modal fade" id="ActivateOptionsModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="ActivateOptionsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ActivateOptionsModalCenterTitle">Activate Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ActivateOptionsModelContent">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Activate Options -->

    <div class="card-body">

        {{-- Realtime Search --}}
        <nav class="navbar justify-content-end">
            <form class="form-inline">
                {{-- id_serach --}}
                <input class="form-control mr-sm-2" id="id_serach" type="search" placeholder="Customer ID"
                    onblur="serachCustomerId(this.value)">
                {{-- id_serach --}}

                {{-- mobile_serach --}}
                <input class="form-control mr-sm-2" id="mobile_serach" type="search" placeholder="Search Mobile.."
                    onchange="serachCustomerMobile(this.value)">
                {{-- mobile_serach --}}

                {{-- username_serach --}}
                <input class="form-control mr-sm-2" id="username_serach" type="search" placeholder="Search username.."
                    onchange="serachCustomerUsername(this.value)">
                {{-- username_serach --}}

                {{-- name_serach --}}
                <input class="form-control mr-sm-2" id="name_serach" type="search" placeholder="Search Full Name.."
                    onchange="serachCustomerName(this.value)">
                {{-- name_serach --}}

            </form>
        </nav>
        {{-- Realtime Search --}}

        <div id='search_result'></div>

        <form action="{{ route('multiple-customer-update') }}" method="POST" onsubmit="showWait()">
            @csrf

            <table id="phpPaging" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center;">
                            <input id="selectAll" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mobile &amp; <br> Name</th>
                        <th scope="col">Username &amp; <br> Password</th>
                        <th scope="col">package &amp; <br> Validity</th>
                        <th scope="col">Payment Status &amp; <br> Status </th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($customers as $customer )
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}">
                        </td>

                        <td scope="row">{{ $customer->id }}</td>

                        <td>
                            <a href="#" onclick="showCustomerDetails('{{ $customer->id }}')">
                                {{ $customer->mobile }}
                            </a>
                            <br>
                            {{ $customer->name }}
                        </td>

                        <td>
                            {{ $customer->username }}
                            <br>
                            {{ $customer->password }}
                        </td>
                        <td>
                            {{ $customer->package_name }}
                            <br>
                            {{ $customer->package_expired_at }}
                            <br>
                            {{ $customer->remaining_validity }}
                        </td>
                        <td>
                            <span class="{{ $customer->payment_color }}"> {{ $customer->payment_status }} </span>
                            <br>
                            <span class="{{ $customer->color }}"> {{ $customer->status }} </span>

                        </td>
                        <td>
                            @include('admins.components.actions-on-customers')
                        </td>
                    </tr>
                    @endforeach

                </tbody>

            </table>

            {{-- with selected --}}
            <div class="form-row align-items-center">

                {{-- options --}}
                <div class="col-auto my-4">
                    <select class="form-control" name="verb" id="inlineFormCustomSelect"
                        onchange="selectOption(this.value)" required>
                        <option value="">with selected...</option>
                        <option value="activate">Activate</option>
                        <option value="suspend">Suspend</option>
                        @if (Auth::user()->role !== 'manager')
                        <option value="extend_package_validity">Extend Package Validity (Daily Billing & Hotspot)
                        </option>
                        @endif
                        @if (Auth::user()->role == 'group_admin')
                        <option value="delete">Delete</option>
                        <option value="change_operator">Change Operator</option>
                        <option value="change_package">Change Package</option>
                        <option value="change_exp_date">Edit Validity/Suspend Date (Without Accounting)</option>
                        <option value="change_billing_profile">Change Billing Profile</option>
                        <option value="generate_bill">Generate Bill</option>
                        @endif
                    </select>
                </div>
                {{-- options --}}

                @if (Auth::user()->role !== 'manager')
                <div class="col-auto my-4" id="select_validity">
                    <input type="number" name='validity' id='validity' class='form-control' value="7" min="7"
                        autocomplete="off">
                </div>
                @endif

                @if (Auth::user()->role == 'group_admin')
                {{-- operator --}}
                <div class="col-auto my-4" id="select_operator_option">
                    <select name="operator_id" id="new_operator_id" class="form-control">
                        <option value=''>operator...</option>
                        @foreach (Auth::user()->operators->where('role', '!=', 'manager') as $operator)
                        <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
                        @endforeach
                    </select>
                </div>
                {{-- operator --}}

                {{-- Package --}}
                <div class="col-auto my-4" id="select_package_option">
                    <select name="package_id" id="new_package_id" class="form-control">
                        <option value=''>package...</option>
                        @foreach (Auth::user()->allPackages->groupBy('operator_id') as $gpackages)
                        @foreach ($gpackages->sortBy('name') as $package)
                        <option value="{{ $package->id }}">{{ $package->operator->name }} :: {{ $package->name }}
                        </option>
                        @endforeach
                        @endforeach
                    </select>
                </div>
                {{-- Package --}}

                <!--change_exp_date-->
                <div class="col-auto my-4" id="select_exp_date">
                    <input type='text' name='new_exp_date' id='new_exp_date' class='form-control'
                        placeholder="Suspend Date" autocomplete="off">
                </div>
                <!--/change_exp_date-->

                {{-- billing_profile_id --}}
                <div class="col-auto my-4" id="select_billing_profile_option">
                    <select name="billing_profile_id" id="new_billing_profile_id" class="form-control">
                        <option value=''>Billing Profile...</option>
                        @foreach (Auth::user()->billing_profiles as $billing_profile)
                        <option value="{{ $billing_profile->id }}">{{ $billing_profile->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- billing_profile_id --}}

                @endif

                {{-- Submit btn --}}
                <div class="col-auto my-1">
                    <button type="submit" class="btn btn-primary" id="btn-submit" disabled="disabled">Submit</button>
                </div>
                {{-- /Submit btn --}}

            </div>
            {{-- with selected --}}


        </form>

    </div>


    <div class="card-footer">
        <div class="row">

            <div class="col-sm-2">
                Total Entries: {{ $customers->total() }}
            </div>

            <div class="col-sm-6">
                {{ $customers->links() }}
            </div>

        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')
<script>
    $(document).ready(function () {

        $("#select_operator_option").hide();
        $("#select_package_option").hide();
        $("#select_billing_profile_option").hide();
        $("#select_exp_date").hide();
        $("#select_validity").hide();

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });

        $('[data-mask]').inputmask();

        $(function() {
            $('#new_exp_date').datepicker({
                autoclose: !0
            });
        });

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

        $.ajax({
            url: "/admin/customer-names"
        }).done(function (result) {
            let names = jQuery.parseJSON(result);
            $("#name_serach").autocomplete({
                source: names,
                autoFocus: true
            });
        });

    });

    $("#selectAll").click(function(){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    function serachCustomerId(customer_id) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (customer_id.length > 1) {
            $.ajax({
                url: "/admin/customer-id/" + customer_id
            }).done(function (data) {
                $("#search_result").html(data);
            });
        } else {
            $("#search_result").html("");
        }
    }

    function serachCustomerMobile(customer_mobile) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (customer_mobile.length > 1) {
            $.ajax({
                url: "/admin/customer-mobiles/" + customer_mobile
            }).done(function (data) {
                $("#search_result").html(data);
            });
        } else {
            $("#search_result").html("");
        }
    }


    function serachCustomerUsername(customer_username) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (customer_username.length > 1) {
            $.ajax({
                url: "/admin/customer-usernames/" + customer_username
            }).done(function (data) {
                $("#search_result").html(data);
            });
        } else {
            $("#search_result").html("");
        }
    }

    function serachCustomerName(customer_name) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (customer_name.length > 1) {
            $.ajax({
                url: "/admin/customer-names/" + customer_name
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
        $("#ModalBody").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Loading...</div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Please Wait</div>');
        $('#modal-customer').modal('show');
        $.get( "/admin/customer-details/" + customer, function( data ) {
            $("#ModalBody").html(data);
        });
    }

    function deleteCustomer(url)
    {
        $("#delete-form" ).attr( "action", url );
        $('#modal-delete').modal('show');
    }

    function selectOption(value){

        console.log(value);

        switch (value) {
        case 'change_operator':
            document.getElementById("new_operator_id").required = true;
            document.getElementById("new_package_id").required = false;
            document.getElementById("new_exp_date").required = false;
            document.getElementById("new_billing_profile_id").required = false;
            document.getElementById("validity").required = false;
            $("#select_package_option").hide();
            $("#select_exp_date").hide();
            $("#select_billing_profile_option").hide();
            $("#select_operator_option").show();
            $("#select_validity").hide();
            $("#btn-submit").attr("disabled",false);
            break;
        case 'change_package':
            document.getElementById("new_operator_id").required = false;
            document.getElementById("new_exp_date").required = false;
            document.getElementById("new_billing_profile_id").required = false;
            document.getElementById("new_package_id").required = true;
            document.getElementById("validity").required = false;
            $("#select_package_option").show();
            $("#select_operator_option").hide();
            $("#select_exp_date").hide();
            $("#select_billing_profile_option").hide();
            $("#select_validity").hide();
            $("#btn-submit").attr("disabled",false);
            break;
        case 'change_billing_profile':
            document.getElementById("new_billing_profile_id").required = true;
            document.getElementById("new_exp_date").required = false;
            document.getElementById("new_operator_id").required = false;
            document.getElementById("new_package_id").required = false;
            document.getElementById("validity").required = false;
            $("#select_package_option").hide();
            $("#select_operator_option").hide();
            $("#select_exp_date").hide();
            $("#select_billing_profile_option").show();
            $("#select_validity").hide();
            $("#btn-submit").attr("disabled",false);
            break;
        case 'change_exp_date':
            document.getElementById("new_billing_profile_id").required = false;
            document.getElementById("new_exp_date").required = true;
            document.getElementById("new_operator_id").required = false;
            document.getElementById("new_package_id").required = false;
            document.getElementById("validity").required = false;
            $("#select_package_option").hide();
            $("#select_operator_option").hide();
            $("#select_exp_date").show();
            $("#select_billing_profile_option").hide();
            $("#select_validity").hide();
            $("#btn-submit").attr("disabled",false);
            break;

        case 'extend_package_validity':
            if ( $( "#new_billing_profile_id" ).length ) {
                document.getElementById("new_billing_profile_id").required = false;
            }
            if ( $( "#new_exp_date" ).length ) {
                document.getElementById("new_exp_date").required = false;
            }
            if ( $( "#new_operator_id" ).length ) {
                document.getElementById("new_operator_id").required = false;
            }
            if ( $( "#new_package_id" ).length ) {
                document.getElementById("new_package_id").required = false;
            }
            document.getElementById("validity").required = true;
            if ( $( "#select_package_option" ).length ) {
                $("#select_package_option").hide();
            }
            if ( $( "#select_operator_option" ).length ) {
                $("#select_operator_option").hide();
            }
            if ( $( "#select_exp_date" ).length ) {
                $("#select_exp_date").hide();
            }
            if ( $( "#select_billing_profile_option" ).length ) {
                $("#select_billing_profile_option").hide();
            }
            $("#select_validity").show();
            $("#btn-submit").attr("disabled",false);
            break;

        default:
            if ( $( "#new_package_id" ).length ) {
                document.getElementById("new_package_id").required = false;
            }
            if ( $( "#new_operator_id" ).length ) {
                document.getElementById("new_operator_id").required = false;
            }
            if ( $( "#new_exp_date" ).length ) {
                document.getElementById("new_exp_date").required = false;
            }
            if ( $( "#new_billing_profile_id" ).length ) {
                document.getElementById("new_billing_profile_id").required = false;
            }
            if ( $( "#validity" ).length ) {
                document.getElementById("validity").required = false;
            }
            if ( $( "#select_package_option" ).length ) {
                $("#select_package_option").hide();
            }
            if ( $( "#select_operator_option" ).length ) {
                $("#select_operator_option").hide();
            }
            if ( $( "#select_exp_date" ).length ) {
                $("#select_exp_date").hide();
            }
            if ( $( "#select_billing_profile_option" ).length ) {
                $("#select_billing_profile_option").hide();
            }
            if ( $( "#select_validity" ).length ) {
                $("#select_validity").hide();
            }
            $("#btn-submit").attr("disabled",false);
        }
    }

    function showSpecialPrice(url)
    {
        $.get( url, function( data ) {
            $("#modal-title").html("Special Price");
            $("#ModalBody").html(data);
            $('#modal-customer').modal('show');
        });
    }

    function showActivateOptions(url)
    {
        $.get( url, function( data ) {
            $("#ActivateOptionsModelContent").html(data);
            $('#ActivateOptionsModalCenter').modal('show');
        });
    }

</script>
@endsection
