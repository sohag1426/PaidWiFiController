@section('contentTitle')
<h3>Event Text Messaging </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <table id="data_table" class="table table-bordered">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Event</th>
                    <th scope="col">Default SMS</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($event_smses as $event_sms )
                <tr>
                    <td>{{ $event_sms->id }}</td>
                    <td>{{ $event_sms->readable_event }}</td>
                    <td>{{ $event_sms->default_sms }}</td>
                    <td>
                        <span class="{{ $event_sms->color }}">
                            {{ $event_sms->status }}
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm mb-1"
                            href="{{ route('event_sms.show', ['event_sms' => $event_sms->id]) }}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        <a class="btn btn-info btn-sm"
                            href="{{ route('event_sms.edit', ['event_sms' => $event_sms->id]) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
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
