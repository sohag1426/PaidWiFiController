@section('contentTitle')
<h3>SMS Bills </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <table id="data_table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Operator</th>
                    <th scope="col">SMS Count</th>
                    <th scope="col">SMS Cost</th>
                    <th scope="col">From Date</th>
                    <th scope="col">To Date</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sms_bills as $sms_bill )
                <tr>
                    <th scope="row">{{ $sms_bill->id }}</th>
                    <td>
                        {{ $sms_bill->operator->name }} ,
                        {{ $sms_bill->operator->readable_role }} ,
                        {{ $sms_bill->operator->company }}
                    </td>
                    <td>{{ $sms_bill->sms_count }}</td>
                    <td>{{ $sms_bill->sms_cost }}</td>
                    <td>{{ $sms_bill->from_date }}</td>
                    <td>{{ $sms_bill->to_date }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm"
                            href="{{ route('sms_bills.edit',['sms_bill' => $sms_bill->id]) }}">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </a>
                        <form method="post" action="{{ route('sms_bills.destroy', ['sms_bill' => $sms_bill->id]) }}"
                            onsubmit="return confirm('Are you sure to Delete')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"><i
                                    class="fas fa-trash"></i>Delete</button>
                        </form>
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
