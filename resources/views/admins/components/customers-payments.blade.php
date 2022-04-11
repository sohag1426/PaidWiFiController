@section('contentTitle')

{{-- @Filter --}}
<form class="d-flex align-content-start flex-wrap" action="{{ route('customer_payments.index') }}" method="get">

    {{-- Group Admin --}}
    @if (Auth::user()->role == 'super_admin')
    <div class="form-group col-md-2">
        <select name="operator_id" id="operator_id" class="form-control">
            <option value=''>Admin...</option>
            @foreach ($group_admins as $group_admin)
            <option value="{{ $group_admin->id }}"> {{ $group_admin->name }} </option>
            @endforeach
        </select>
    </div>
    @endif
    {{--Group Admin --}}

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

    {{-- cash_collector --}}
    <div class="form-group col-md-2">
        <select name="cash_collector_id" id="cash_collector_id" class="form-control">
            <option value=''>Cash Collector...</option>
            @foreach (Auth::user()->operators->where('role', 'manager')->push(Auth::user()) as $manager)
            <option value="{{ $manager->id }}"> {{ $manager->name }} </option>
            @endforeach
        </select>
    </div>
    {{--cash_collector --}}

    {{-- type --}}
    @if (Auth::user()->role !== 'super_admin')
    <div class="form-group col-md-2">
        <select name="type" id="type" class="form-control">
            <option value=''>payment type...</option>
            <option value='Cash'>Cash</option>
            <option value='Online'>Online</option>
            <option value='RechargeCard'>RechargeCard</option>
        </select>
    </div>
    @endif
    {{--type --}}

    {{-- year --}}
    <div class="form-group col-md-2">
        <select name="year" id="year" class="form-control">
            <option value=''>year...</option>
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
            <option value=''>month...</option>
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

    <!-- date -->
    <div class="form-group col-md-2">
        <input type="text" name="date" class="form-control" id="datepicker" placeholder="date">
    </div>
    <!-- /date -->

    {{-- note --}}
    <div class="form-group col-md-2">
        <input type="text" name="note" id="note" class="form-control" placeholder="note ...">
    </div>
    {{-- note --}}

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

    <div class="form-group col-md-1">
        <button type="submit" class="btn btn-dark">FILTER</button>
    </div>

</form>

{{-- @endFilter --}}


{{-- Download & Upload --}}
@can('downloadPayments')
<ul class="nav justify-content-end">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('customer-payments-download.create') }}">
            <i class="fas fa-download"></i> Download Payments
        </a>
    </li>

</ul>
@endcan
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

    <div class="card-body">

        {{-- Realtime Search --}}
        <nav class="navbar justify-content-end">

            <p class="font-weight-bold mr-4">Total Amount: {{ $total_amount }}</p>

            <form class="form-inline">
                {{-- mobile_serach --}}
                <input class="form-control mr-sm-2" id="mobile_serach" placeholder="Search Mobile.."
                    onchange="serachCustomerPayments(this.value)">
                {{-- mobile_serach --}}

                {{-- username_serach --}}
                <input class="form-control mr-sm-2" id="username_serach" placeholder="Search username.."
                    onchange="serachCustomerUsername(this.value)">
                {{-- username_serach --}}
            </form>
        </nav>
        {{-- Realtime Search --}}

        <div id='search_result'></div>

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name <br> Username</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Status</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Service Charge</th>
                    <th scope="col">Store Amount</th>
                    <th scope="col">Payment Gateway</th>
                    <th scope="col">Date</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($payments as $payment )
                <tr>
                    <th scope="row">{{ $payment->id }}</th>
                    <td>
                        {{ $payment->name }} <br>
                        {{ $payment->username }}
                    </td>
                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $payment->customer_id }}')">
                            {{ $payment->mobile }}
                        </a>
                    </td>
                    <td>{{ $payment->pay_status }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->transaction_fee }}</td>
                    <td>{{ $payment->store_amount }}</td>
                    @if ($payment->type == 'RechargeCard')
                    <td>{{ $payment->recharge_card->distributor->name }}</td>
                    @else
                    <td>{{ $payment->payment_gateway_name }}</td>
                    <td>{{ $payment->date }}</td>
                    @endif

                    <td>

                        @if (Auth::user()->can('update', $payment) || Auth::user()->can('delete', $payment))

                        <div class="btn-group" role="group">

                            <button id="btnGroupActionsOnCustomer" type="button" class="btn btn-danger dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>

                            <div class="dropdown-menu" aria-labelledby="btnGroupActionsOnCustomer">
                                {{-- --}}
                                @can('update', $payment)
                                <a class="dropdown-item"
                                    href="{{ route('customer_payments.edit.create', ['customer_payment' => $payment->id]) }}">
                                    Edit
                                </a>
                                @endcan
                                {{-- --}}
                                @can('delete', $payment)
                                <a class="dropdown-item"
                                    href="{{ route('customer_payments.destroy.create', ['customer_payment' => $payment->id]) }}">
                                    Delete
                                </a>
                                @endcan
                                {{-- --}}
                            </div>

                        </div>

                        @endif

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <!--/card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Entries: {{ $payments->total() }}
            </div>
            <div class="col-sm-6">
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')

<script>
    $(document).ready(function () {

        $(function() {
            $('#datepicker').datepicker({
                autoclose: !0
            });
        });

        $.ajax({
            url: "/admin/customer-mobiles"
        }).done(function (result) {
            let mobiles = jQuery.parseJSON(result);
            $("#mobile_serach").autocomplete({
                source: mobiles
            });
        });

        $.ajax({
            url: "/admin/customer-usernames"
        }).done(function (result) {
            let usernames = jQuery.parseJSON(result);
            $("#username_serach").autocomplete({
                source: usernames
            });
        });

    });

    function serachCustomerPayments(mobile) {
        $("#search_result").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        if (mobile.length > 1) {
            $.ajax({
                url:  "/admin/customer_payments/" + mobile + "?fieldname=mobile"
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
                url: "/admin/customer_payments/" + customer_username + "?fieldname=username"
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

</script>
@endsection
