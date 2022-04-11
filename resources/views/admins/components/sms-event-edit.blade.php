@section('contentTitle')
<h3>Event Text Messaging </h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST" action="{{ route('event_sms.update', ['event_sms' => $event_sms->id]) }}">

            @csrf

            @method('put')

            {{-- event --}}
            <div class="form-group">
                <label for="event">Event</label>
                <input type="text" class="form-control" id="event" value="{{ $event_sms->readable_event }}" disabled>
            </div>
            {{-- event --}}

            {{-- status --}}
            @can('updateStatus', $event_sms)
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" id="status" required>
                    <option selected>{{ $event_sms->status }}</option>
                    <option value="enabled">enabled</option>
                    <option value="disabled">disabled</option>
                </select>
            </div>

            @else
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" value="{{ $event_sms->status }}" disabled>
            </div>
            @endcan
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
                <textarea name="operator_sms" class="form-control" id="operator_sms" rows="3">{{ $event_sms->operator_sms }}</textarea>
            </div>
            {{-- operator_sms --}}

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
