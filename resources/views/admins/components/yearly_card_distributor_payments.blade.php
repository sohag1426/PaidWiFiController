@section('contentTitle')

<form class="d-flex align-content-start flex-wrap" method="GET"
    action="{{ route('yearly_card_distributor_payments.index') }}">

    <!--distributor_id-->
    <div class="form-group col-md-2">
        <select name="distributor_id" class="form-control">
            <option selected value="">distributor...</option>
            @foreach ($distributors as $distributor)
            <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
            @endforeach
        </select>
    </div>
    <!--/distributor_id-->

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

    <div class="form-group col-md-2">
        <button type="submit" class="btn btn-dark">FILTER</button>
    </div>

</form>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <table id="phpPaging" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">Year</th>
                    <th scope="col">Month</th>
                    <th scope="col">Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <td scope="row">{{ $payment->id }}</td>
                    @if ($payment->distributor)
                    <td>{{ $payment->distributor->name }}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $payment->year }}</td>
                    <td>{{ $payment->month }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    {{-- card-footer --}}
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
    {{-- card-footer --}}

</div>

@endsection

@section('pageJs')
@endsection
