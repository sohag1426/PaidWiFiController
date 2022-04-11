@section('contentTitle')
<h3>SMS Histories </h3>
@endsection

@section('content')

<div class="card">

    {{-- @Filter --}}
    <form class="d-flex align-content-start flex-wrap mt-2" action="{{ route('sms_histories.index') }}" method="get">

        {{-- to_number --}}
        <div class="form-group col-md-2">
            <input type="text" name="to_number" id="to_number" class="form-control" placeholder="mobile number">
        </div>
        {{-- to_number --}}

        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-dark">FILTER</button>
        </div>

    </form>
    {{-- @endFilter --}}

    <div class="card-body">

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">To Number</th>
                    <th scope="col">Message</th>
                    <th scope="col">Status</th>
                    <th scope="col">Status Details</th>
                    <th scope="col">Bill ID</th>
                    <th scope="col">SMS Count</th>
                    <th scope="col">SMS Cost</th>
                    <th scope="col">Time</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($histories as $history )
                <tr>
                    <td>{{ $history->to_number }}</td>
                    <td>{{ $history->sms_body }}</td>
                    <td>{{ $history->status_text }}</td>
                    <td>{{ $history->status_details }}</td>
                    <td>{{ $history->sms_bill_id }}</td>
                    <td>{{ $history->sms_count }}</td>
                    <td>{{ $history->sms_cost }}</td>
                    <td>{{ $history->created_at }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Entries: {{ $histories->total() }}
            </div>
            <div class="col-sm-6">
                {{ $histories->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')
@endsection
