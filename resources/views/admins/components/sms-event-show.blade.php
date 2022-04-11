@section('contentTitle')
<h3>Event Text Messaging </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form>

            {{-- event --}}
            <div class="form-group">
                <label for="event">Event</label>
                <input type="text" class="form-control" id="event" value="{{ $event_sms->readable_event }}" disabled>
            </div>
            {{-- event --}}

            {{-- status --}}
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" value="{{ $event_sms->status }}" disabled>
            </div>
            {{-- status --}}

            {{-- variables --}}
            <div class="form-group">
                <label for="variables">Variables</label>
                <input type="text" class="form-control" id="variables" value="{{ $event_sms->variables }}" disabled>
            </div>
            {{-- variables --}}

            {{-- default_sms --}}
            <div class="form-group">
                <label for="default_sms">Default SMS Format</label>
                <textarea class="form-control" id="default_sms" rows="3"
                    disabled>{{ $event_sms->default_sms }}</textarea>
            </div>
            {{-- default_sms --}}

            {{-- operator_sms --}}
            <div class="form-group">
                <label for="operator_sms">Your Format</label>
                <textarea class="form-control" id="operator_sms" rows="3"
                    disabled>{{ $event_sms->operator_sms }}</textarea>
            </div>
            {{-- operator_sms --}}

        </form>

        <a class="btn btn-primary" href="{{ route('event_sms.edit', ['event_sms' => $event_sms->id ]) }}"
            role="button">Edit</a>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
