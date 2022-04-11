@section('contentTitle')

<ul class="nav flex-column flex-sm-row">

    <!--Title-->
    <li class="nav-item mr-2">
        <h3>SMS Payments</h3>
    </li>
    <!--/Title-->

    <!--Add SMS Balance-->
    <li class="nav-item mr-2">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('advance_sms_payments.create') }}">
            <i class="fas fa-plus"></i>
            Add SMS Balance
        </a>
    </li>
    <!--/Add SMS Balance-->

    <!--SMS Balance history-->
    <li class="nav-item">
        <a class="btn btn-outline-dark my-2 my-sm-0" href="{{ route('sms_balance_histories.index') }}">
            <i class="fas fa-history"></i>
            SMS Balance History
        </a>
    </li>
    <!--/SMS Balance history-->

</ul>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        {{-- @Filter --}}
        <form class="d-flex align-content-start flex-wrap mb-2" action="{{ route('sms_payments.index') }}" method="get">

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

            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-dark">FILTER</button>
            </div>

        </form>

        {{-- @endFilter --}}

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SMS Count</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Payment Gateway</th>
                    <th scope="col">Pay Status</th>
                    <th scope="col">Store Amount</th>
                    <th scope="col">Transaction Fee</th>
                    <th scope="col">Date</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sms_payments as $sms_payment )
                <tr>
                    <th scope="row">{{ $sms_payment->id }}</th>
                    <td>{{ $sms_payment->sms_count }}</td>
                    <td>{{ $sms_payment->amount_paid }}</td>
                    <td>{{ $sms_payment->payment_gateway_name }}</td>
                    <td>{{ $sms_payment->pay_status }}</td>
                    <td>{{ $sms_payment->store_amount }}</td>
                    <td>{{ $sms_payment->transaction_fee }}</td>
                    <td>{{ $sms_payment->date }}</td>
                    @if ($sms_payment->pay_status !== 'Successful')
                    <td>
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('sms_payments.recheck', ['sms_payment' => $sms_payment->id]) }}">
                            <i class="fas fa-link"></i>
                            Recheck
                        </a>
                    </td>
                    @else
                    <td></td>
                    @endif
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>


    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Amount: {{ $total_amount }}
            </div>
            <div class="col-sm-2">
                Total Entries: {{ $sms_payments->total() }}
            </div>
            <div class="col-sm-6">
                {{ $sms_payments->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')
@endsection
