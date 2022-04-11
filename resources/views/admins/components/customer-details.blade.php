{{-- Navigation bar --}}
<ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="true">Profile</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="Bills-tab" data-toggle="tab" href="#Bills" role="tab" aria-controls="Bills"
            aria-selected="false">Bills</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="PaymentHistory-tab" data-toggle="tab" href="#PaymentHistory" role="tab"
            aria-controls="PaymentHistory" aria-selected="false">Payment History</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="InternetHistory-tab" data-toggle="tab" href="#InternetHistory" role="tab"
            aria-controls="InternetHistory" aria-selected="false">Internet History</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="Bandwidth-graph-tab" data-toggle="tab" href="#BandwidthGraph" role="tab"
            aria-controls="BandwidthGraph" aria-selected="false">
            Bandwidth Graph
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="SmsHistory-tab" data-toggle="tab" href="#SmsHistory" role="tab"
            aria-controls="SmsHistory" aria-selected="false">SMS History</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" id="package_change_history-tab" data-toggle="tab" href="#package_change_history" role="tab"
            aria-controls="package_change_history" aria-selected="false">Package Change History</a>
    </li>

</ul>
{{-- Navigation bar --}}

<div class="tab-content" id="myTabContent">



    {{-- Profile --}}
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">


        <div class="row">

            {{-- First Column --}}
            <div class="col-sm-4">

                {{-- General Information --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            General Information
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Operator ID
                            <span class="badge badge-pill">{{ $customer->operator_id }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Company
                            <span class="badge badge-pill">{{ $customer->company }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Connection Type
                            <span class="badge badge-pill">{{ $customer->connection_type }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Customer Status
                            <span class="text-danger">{{ $customer->status }}</span>
                        </li>

                        @if ($customer->status === 'suspended')
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Suspend Reason
                            <span class="text-danger">{{ $customer->suspend_reason }}</span>
                        </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Billing Profile
                            <span class="badge badge-pill">{{ $customer->billing_profile }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Name
                            <span class="badge badge-pill">{{ $customer->name }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Mobile
                            <span class="badge badge-pill">{{ $customer->mobile }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Email
                            <span class="badge badge-pill">{{ $customer->email }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Payment Status
                            <span class="badge badge-pill">{{ $customer->payment_status }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Advance Payment
                            <span class="badge badge-pill">{{ $customer->advance_payment }}
                                {{ config('consumer.currency') }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            zone
                            <span class="badge badge-pill">{{ $customer->zone }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            NID Number
                            <span class="badge badge-pill">{{ $customer->nid }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Registration date
                            <span class="badge badge-pill">{{ $customer->registration_date }}</span>
                        </li>

                        @foreach ($customer->custom_attributes as $custom_attribute)

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $custom_attribute->name }}
                            <span class="badge badge-pill">{{ $custom_attribute->value }}</span>
                        </li>

                        @endforeach


                    </ul>

                </div>
                {{-- General Information --}}

            </div>
            {{-- First Column --}}

            {{-- Second Column --}}
            <div class="col-sm-4">


                {{-- Customer Address --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            Customer Address
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {!! $customer->address !!}
                        </li>

                    </ul>

                </div>
                {{-- Customer Address--}}

                {{-- Package Information --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            Package Information
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Package
                            <span class="badge badge-pill">{{ $customer->package_name }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Started At
                            <span class="badge badge-pill">{{ $customer->package_started_at }}</span>
                        </li>


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valid Until
                            <span class="badge badge-pill">{{ $customer->package_expired_at }}</span>
                        </li>

                        @if ($customer->rate_limit)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Rate Limit
                            <span class="badge badge-pill">{{ $customer->rate_limit }}</span>
                        </li>
                        @else

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Rate Limit
                            <span class="badge badge-pill">N/A</span>
                        </li>

                        @endif

                        @if ($customer->total_octet_limit)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Volume Limit
                            <span class="badge badge-pill">{{ $customer->total_octet_limit/1000/1000/1000 }} GB</span>
                        </li>
                        @else
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Volume Limit
                            <span class="badge badge-pill">N/A</span>
                        </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Volume Used
                            <span class="badge badge-pill">
                                {{ ($customer->radaccts->sum('acctoutputoctets') +
                                $customer->radaccts->sum('acctinputoctets') + $radaccts_history->sum('acctoutputoctets')
                                + $radaccts_history->sum('acctinputoctets'))/1000/1000/1000 }}
                                GB
                            </span>
                        </li>

                    </ul>

                </div>
                {{-- Package Information --}}
            </div>
            {{-- Second Column --}}

            {{-- Third Column --}}
            <div class="col-sm-4">

                {{-- Username & Password --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            Username & Password
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Username
                            <span class="badge badge-pill">{{ $customer->username }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Password
                            <span class="badge badge-pill">{{ $customer->password }}</span>
                        </li>
                    </ul>

                </div>
                {{-- Username & Password --}}

                {{-- Router & IP Address --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            Router & IP Address
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Router
                            <span class="badge badge-pill">
                                {{ $customer->router->id > 0 ? $customer->router->nasname : $customer->router_ip }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            IP Address
                            <span class="badge badge-pill">{{ $customer->login_ip }}</span>
                        </li>
                    </ul>

                </div>
                {{-- Router & IP Address --}}

                {{-- MAC Address & MAC Bind --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            MAC Address & MAC Bind
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            MAC Address
                            <span class="badge badge-pill">{{ $customer->login_mac_address }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            MAC Bind
                            <span class="badge badge-pill">{{ $customer->mac_bind }}</span>
                        </li>
                    </ul>

                </div>
                {{-- MAC Address & MAC Bind --}}

                {{-- comment --}}
                <div class="card-body">

                    <ul class="list-group">

                        <button type="button" class="list-group-item list-group-item-action active">
                            Comment
                        </button>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {!! $customer->comment !!}
                        </li>

                    </ul>

                </div>
                {{-- comment --}}

            </div>
            {{-- Third Column --}}

        </div>
        {{-- row --}}

    </div>
    {{-- Profile --}}

    {{-- Bills --}}
    <div class="tab-pane fade" id="Bills" role="tabpanel" aria-labelledby="Bills-tab">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">package</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Billing Period</th>
                    <th scope="col">Due Date</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($bills as $bill )
                <tr>
                    <td>{{ $bill->id }}</td>
                    <td>{{ $bill->customer_id }}</td>
                    <td>{{ $bill->username }}</td>
                    <td>{{ $bill->mobile }} </td>
                    <td>{{ $bill->description }}</td>
                    <td>{{ $bill->amount }}</td>
                    <td>{{ $bill->billing_period }}</td>
                    <td>{{ $bill->due_date }}</td>
                    <td>
                        <div class="btn-group" role="group">

                            <button id="btnGroupActionsOnCustomer" type="button" class="btn btn-danger dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>

                            <div class="dropdown-menu" aria-labelledby="btnGroupActionsOnCustomer">

                                {{-- --}}
                                @can('receivePayment', $bill)
                                <a class="dropdown-item"
                                    href="{{ route('customer_bills.cash-payments.create', ['customer_bill' => $bill->id]) }}">
                                    Paid
                                </a>
                                @endcan
                                {{-- --}}
                                @can('editInvoice', $bill)
                                <a class="dropdown-item"
                                    href="{{ route('customer_bills.edit', ['customer_bill' => $bill->id]) }}">
                                    Edit
                                </a>
                                @endcan
                                {{-- --}}
                                @can('printInvoice', $bill)
                                <a class="dropdown-item"
                                    href="{{ route('customer_bills.print', ['customer_bill' => $bill->id]) }}">
                                    Print/Download
                                </a>
                                @endcan
                                {{-- --}}

                            </div>

                        </div>

                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>

    </div>
    {{-- Bills --}}

    {{-- Payment History --}}
    <div class="tab-pane fade" id="PaymentHistory" role="tabpanel" aria-labelledby="PaymentHistory-tab">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Payment Gateway</th>
                    <th scope="col">Payment type</th>
                    <th scope="col">pay status</th>
                    <th scope="col">amount</th>
                    <th scope="col">Transaction fee</th>
                    <th scope="col">Date</th>
                    <th scope="col">TxnID/PIN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->payments as $payment)
                <tr>
                    <td>{{ $payment->payment_gateway_name }}</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->pay_status }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->transaction_fee }}</td>
                    <td>{{ $payment->date }}</td>
                    <td>{{ $payment->bank_txnid }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{-- Payment History --}}

    {{-- Internet History --}}
    <div class="tab-pane fade" id="InternetHistory" role="tabpanel" aria-labelledby="InternetHistory-tab">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Start Time</th>
                    <th scope="col">Stop Time</th>
                    <th scope="col">Total Time</th>
                    <th scope="col">Terminate Cause</th>
                    <th scope="col">Download(MB)</th>
                    <th scope="col">Upload(MB)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total_download = 0;
                $total_upload = 0;
                @endphp
                @foreach ($customer->radaccts->sortBy('acctstoptime') as $radacct)
                @php
                $total_download = $total_download + $radacct->acctoutputoctets;
                $total_upload = $total_upload + $radacct->acctinputoctets;
                @endphp
                <tr>
                    <td>{{ $radacct->acctstarttime }}</td>
                    <td>{{ $radacct->acctstoptime }}</td>
                    <td>{{ sToHms($radacct->acctsessiontime) }}</td>
                    <td>{{ $radacct->acctterminatecause }}</td>
                    <td>{{ $radacct->acctoutputoctets/1000000 }}</td>
                    <td>{{ $radacct->acctinputoctets/1000000 }}</td>
                </tr>
                @endforeach
                @foreach ($radaccts_history->sortByDesc('acctstoptime') as $radacct_history)
                @php
                $total_download = $total_download + $radacct_history->acctoutputoctets;
                $total_upload = $total_upload + $radacct_history->acctinputoctets;
                @endphp
                <tr>
                    <td>{{ $radacct_history->acctstarttime }}</td>
                    <td>{{ $radacct_history->acctstoptime }}</td>
                    <td>{{ sToHms($radacct_history->acctsessiontime) }}</td>
                    <td>{{ $radacct_history->acctterminatecause }}</td>
                    <td>{{ $radacct_history->acctoutputoctets/1000000 }}</td>
                    <td>{{ $radacct_history->acctinputoctets/1000000 }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total:</td>
                    <td>{{ $total_download/1000000 }}</td>
                    <td>{{ $total_upload/1000000 }}</td>
                </tr>
            </tbody>
        </table>

    </div>
    {{-- Internet History --}}

    {{-- bandwidth-graph --}}
    <div class="tab-pane fade" id="BandwidthGraph" role="tabpanel" aria-labelledby="Bandwidth-graph-tab">

        <div class="card-body">
            <h5>Hourly Graph</h5>
            <div>
                <img class="img-fluid" src="{{ $graph->get('hourly') }}" alt="Image Not Found">
            </div>
        </div>

        <div class="card-body">
            <h5>Daily Graph</h5>
            <div>
                <img class="img-fluid" src="{{ $graph->get('daily') }}" alt="Image Not Found">
            </div>
        </div>

        <div class="card-body">
            <h5>Weekly Graph</h5>
            <div>
                <img class="img-fluid" src="{{ $graph->get('weekly') }}" alt="Image Not Found">
            </div>
        </div>

        <div class="card-body">
            <h5>Monthly Graph</h5>
            <div>
                <img class="img-fluid" src="{{ $graph->get('monthly') }}" alt="Image Not Found">
            </div>
        </div>

    </div>
    {{-- bandwidth-graph --}}

    {{-- SMS History --}}
    <div class="tab-pane fade" id="SmsHistory" role="tabpanel" aria-labelledby="SmsHistory-tab">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">To Number</th>
                    <th scope="col">Status</th>
                    <th scope="col">SMS Count</th>
                    <th scope="col">SMS Cost</th>
                    <th scope="col">SMS Body</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->sms_histories as $sms_history)
                <tr>
                    <td>{{ $sms_history->to_number }}</td>
                    <td>{{ $sms_history->status_text }}</td>
                    <td>{{ $sms_history->sms_count }}</td>
                    <td>{{ $sms_history->sms_cost }}</td>
                    <td>{{ $sms_history->sms_body }}</td>
                    <td>{{ $sms_history->date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{-- SMS History --}}

    {{-- package_change_history --}}
    <div class="tab-pane fade" id="package_change_history" role="tabpanel" aria-labelledby="package_change_history-tab">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">From Package</th>
                    <th scope="col">To Package</th>
                    <th scope="col">Status</th>
                    <th scope="col">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->package_change_histories as $package_change_history)
                <tr>
                    <td>{{ $package_change_history->from_package }}</td>
                    <td>{{ $package_change_history->to_package }}</td>
                    <td>{{ $package_change_history->status }}</td>
                    <td>{{ $package_change_history->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{-- package_change_history --}}

</div>

{{-- Actions --}}
<fieldset class="border border-info p-2">

    <legend class="w-auto">Actions</legend>

    <div class="d-flex align-content-start flex-wrap">

        @if (Auth::user()->subscription_status === 'suspended')

        <a class="btn btn-link" href="#">
            Subscription Suspended
        </a>

        @else

        {{-- --}}
        @if ($customer->payment_status == 'billed')
        <a class="btn btn-link" href="{{ route('customer_bills.index', ['customer_id' => $customer->id]) }}">
            Bills
        </a>
        @endif
        {{-- --}}
        @can('update', $customer)
        @if (isset($customers))
        <a class="btn btn-link"
            href="{{ route('customers.edit', ['customer' => $customer->id, 'page' => $customers->currentPage()]) }}">
            Edit
        </a>
        @else
        <a class="btn btn-link" href="{{ route('customers.edit', ['customer' => $customer->id, 'page' => 1]) }}">
            Edit
        </a>
        @endif
        @endcan
        {{-- --}}
        @can('activate', $customer)
        <a class="btn btn-link" href="{{ route('customer-activate', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Activate
        </a>
        @endcan
        {{-- --}}
        @can('suspend', $customer)
        <a class="btn btn-link" href="{{ route('customer-suspend', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Suspend
        </a>
        @endcan
        {{-- --}}
        @can('disable', $customer)
        <a class="btn btn-link" href="{{ route('customer-disable', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Disable
        </a>
        @endcan
        {{-- --}}
        @can('editSuspendDate', $customer)
        <a class="btn btn-link" href="{{ route('customers.suspend_date.create', ['customer' => $customer->id ]) }}"
            onclick="showWait()">
            Edit Date
        </a>
        @endcan
        {{-- --}}
        @can('editSpeedLimit', $customer)
        <a class="btn btn-link" href="{{ route('customer-package-time-limit.edit', ['customer' => $customer->id]) }}">
            Edit Time
        </a>
        <a class="btn btn-link" href="{{ route('customer-package-speed-limit.edit', ['customer' => $customer->id]) }}">
            Edit Speed
        </a>
        <a class="btn btn-link" href="{{ route('customer-package-volume-limit.edit', ['customer' => $customer->id]) }}">
            Edit Volume
        </a>
        @endcan
        {{-- --}}
        @can('changePackage', $customer)
        <a class="btn btn-link" href="{{ route('customer-package-change.edit', ['customer' => $customer->id]) }}">
            Edit Package
        </a>
        @endcan
        {{-- --}}
        @can('changeOperator', $customer)
        <a class="btn btn-link" href="{{ route('customers.change_operator.create', ['customer' => $customer->id]) }}">
            Change Operator
        </a>
        @endcan
        {{-- --}}
        @can('generateBill', $customer)
        <a class="btn btn-link" href="{{ route('customers.customer_bills.create', ['customer' => $customer->id]) }}">
            Generate Bill
        </a>
        @endcan
        {{-- --}}
        @can('removeMacBind', $customer)
        <a class="btn btn-link" href="{{ route('mac-bind-destroy', ['customer' => $customer->id]) }}">
            Remove MAC Bind
        </a>
        @endcan
        {{-- --}}
        @can('sendSms', $customer)
        <a class="btn btn-link" href="{{ route('customers.sms_histories.create', ['customer' => $customer->id]) }}">
            SMS
        </a>
        @endcan
        {{-- --}}
        @can('sendLink', $customer)
        <a class="btn btn-link" href="{{ route('customer.send-payment-link.create', ['customer' => $customer->id]) }}">
            Payment Link
        </a>
        @endcan
        {{-- --}}
        @can('advancePayment', $customer)
        <a class="btn btn-link" href="{{ route('customers.advance_payment.create', ['customer' => $customer->id]) }}">
            Advance Payment
        </a>
        @endcan
        {{-- --}}
        @can('activateFup', $customer)
        <a class="btn btn-link" href="{{ route('activate-fup', ['customer' => $customer->id ]) }}" onclick="showWait()">
            FUP
        </a>
        @endcan
        {{-- --}}
        <a class="btn btn-link"
            href="{{ route('customers.customer_complains.create', ['customer' => $customer->id]) }}">
            Add Complaint
        </a>
        {{-- --}}
        <a class="btn btn-link" href="{{ route('customers.internet-history.create', ['customer' => $customer->id]) }}">
            <i class="fas fa-download"></i>
            Internet History
        </a>
        {{-- --}}
        <a class="btn btn-link" href="{{ route('customers.others-payments.create', ['customer' => $customer->id]) }}">
            Other Payment
        </a>
        {{-- --}}
        @can('disconnect', $customer)
        <a class="btn btn-link" href="#"
            onclick="if(confirm('Are you sure?')) callURL('{{ route('customers.disconnect.create', ['customer' => $customer->id]) }}');">
            Disconnect
        </a>
        @endcan
        {{-- --}}
        @endif

    </div>

</fieldset>
{{-- Actions --}}
