@section('contentTitle')

<ul class="nav flex-column flex-sm-row">

    <!--Title-->
    <li class="nav-item mr-2">
        <h3>SMS Balance Histories</h3>
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

        {{-- @Filter --}}
        <form class="d-flex align-content-start flex-wrap mb-2" action="{{ route('sms_balance_histories.index') }}"
            method="get">

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

        <table id="data_table" class="table table-bordered">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Old Balance</th>
                    <th scope="col">New Balance</th>
                    <th scope="col">Time</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($sms_balance_histories as $balance_history )
                <tr>
                    <th scope="row">{{ $balance_history->id }}</th>
                    <td>{{ $balance_history->type }}</td>
                    <td>{{ $balance_history->amount }}</td>
                    <td>{{ $balance_history->old_balance }}</td>
                    <td>{{ $balance_history->new_balance }}</td>
                    <td>{{ $balance_history->created_at }}</td>
                    <td>
                        @if ($balance_history->type == 'out')
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('sms_histories.index', ['sms_bill_id' => $balance_history->sms_bill_id]) }}">
                            <i class="fas fa-link"></i>
                            Details
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
