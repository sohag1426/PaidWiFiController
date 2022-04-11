@section('contentTitle')

<ul class="nav flex-column flex-sm-row">

    <!--Title-->
    <li class="nav-item mr-2">
        <h3>SMS Bills</h3>
    </li>
    <!--/Title-->

    <!--Add SMS Balance-->
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('advance_sms_payments.create') }}">
            <i class="fas fa-plus"></i>
            Add SMS Balance
        </a>
    </li>
    <!--/Add SMS Balance-->

</ul>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            @foreach ($sms_bills as $sms_bill )

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="font-weight-bold"> To:</span>
                                {{ $sms_bill->operator->name }} ,
                                {{ $sms_bill->operator->readable_role }} ,
                                {{ $sms_bill->operator->company }}
                            </li>
                            <li class="list-group-item"><span class="font-weight-bold">SMS Count :</span>
                                {{ $sms_bill->sms_count }} </li>
                            <li class="list-group-item"><span class="font-weight-bold">SMS Cost :</span>
                                {{ $sms_bill->sms_cost }}</li>
                            <li class="list-group-item"><span class="font-weight-bold">From Date :</span>
                                {{ $sms_bill->from_date }}</li>
                            <li class="list-group-item"><span class="font-weight-bold">To Date :</span>
                                {{ $sms_bill->to_date }}
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('sms_histories.index',['sms_bill_id' => $sms_bill->id]) }}"
                                    class="card-link">Details</a>
                            </li>
                        </ul>

                        <hr>

                        <form class="form-inline" method="get"
                            action="{{ route('sms_payments.create',['sms_bill' => $sms_bill->id]) }}"
                            onsubmit="return showWait()">

                            <div class="form-group">
                                <label for="payment_gateway_id" class="sr-only">Payment Gateway</label>

                                <select id="payment_gateway_id" name="payment_gateway_id"
                                    class="form-control form-control-sm" required>
                                    <option value="">Pay With...</option>

                                    @if ($sms_bill->payment_gateways)

                                    @foreach ($sms_bill->payment_gateways as $payment_gateway)

                                    <option value="{{ $payment_gateway->id }}">{{ $payment_gateway->payment_method }}
                                    </option>

                                    @endforeach

                                    @endif

                                </select>

                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">SUBMIT</button>

                        </form>

                    </div>

                </div>

            </div>
            <!--/col-sm-6-->

            @endforeach

        </div>
        <!--/row-->

    </div>

</div>

@endsection

@section('pageJs')
@endsection
