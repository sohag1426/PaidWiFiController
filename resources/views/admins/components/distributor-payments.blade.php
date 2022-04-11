@section('contentTitle')

<form method="GET" action="{{ route('distributor_payments.index') }}">
    <ul class="nav nav-fill flex-column flex-sm-row">
        <!--New Payment-->
        <li class="nav-item">
            <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('distributor_payments.create') }}">
                <i class="fas fa-plus"></i>
                New Payment
            </a>
        </li>
        <!--/New Payment-->
        <!--Summary Report-->
        <li class="nav-item">
            <a class="btn btn-outline-success my-2 my-sm-0"
                href="{{ route('yearly_card_distributor_payments.index') }}">
                <i class="fas fa-list-alt"></i>
                Summary Report
            </a>
        </li>
        <!--/Summary Report-->
        <!--Download Payments-->
        <li class="nav-item">
            <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('distributor_payments_download.create') }}">
                <i class="fas fa-download"></i>
                Download Payments
            </a>
        </li>
        <!--/Download Payments-->
        <!--distributor_id-->
        <li class="nav-item">
            <select name="distributor_id" class="custom-select mr-sm-2">
                <option selected value="">distributor...</option>
                @foreach ($distributors as $distributor)
                <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                @endforeach
            </select>
        </li>
        <!--/distributor_id-->
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
        <li class="nav-item">
            <button type="submit" class="btn btn-primary">FILTER</button>
        </li>
    </ul>
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
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <th scope="row">{{ $payment->id }}</th>
                    <th>{{ $payment->distributor->name }}</th>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->date }}</td>
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
