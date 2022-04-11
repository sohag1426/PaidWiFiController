@section('contentTitle')
<h3>SMS Status</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <ul class="list-group list-group-flush" style="width: 18rem;">
            <li class="list-group-item"><span class="font-weight-bold"> Message: </span> {{ $sms_history->sms_body }}
            </li>
            <li class="list-group-item"><span class="font-weight-bold"> Delivery Status : </span>
                {{ $sms_history->status_text }}</li>
            <li class="list-group-item"><span class="font-weight-bold"> SMS Count :</span> {{ $sms_history->sms_count }}
            </li>
            <li class="list-group-item"><span class="font-weight-bold"> SMS Cost: </span> {{ $sms_history->sms_cost }}
            </li>
            <li class="list-group-item"><a href="{{ route('sms_histories.create') }}" class="card-link">Send Another</a>
            </li>
        </ul>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
