{{-- Navigation bar --}}
<ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="true">Profile</a>
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
        <a class="nav-link" id="SmsHistory-tab" data-toggle="tab" href="#SmsHistory" role="tab"
            aria-controls="SmsHistory" aria-selected="false">SMS History</a>
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
                            Customer Status
                            <span class="text-danger">{{ $customer->status }}</span>
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
                            Registration date
                            <span class="badge badge-pill">{{ $customer->registration_date }}</span>
                        </li>

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

</div>
