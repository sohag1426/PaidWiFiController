@section('contentTitle')
<h3>SMS Broadcast</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">

                <form method="POST"
                    action="{{ route('sms-broadcast-jobs.update', ['sms_broadcast_job' => $sms_broadcast_job->id]) }}">

                    @csrf

                    @method('PUT')

                    <!--message-->
                    <div class="form-group">
                        <label for="message">Text Message</label>
                        <textarea class="form-control" id="message" rows="3"
                            disabled> {{ $sms_broadcast_job->message }}</textarea>
                    </div>
                    <!--/message-->

                    <!--customer_count-->
                    <div class="form-group">
                        <label for="customer_count">Customer Count</label>
                        <select class="form-control" id="customer_count" disabled>
                            <option>{{ $sms_broadcast_job->message_count }}</option>
                        </select>
                    </div>
                    <!--/customer_count-->

                    <button type="submit" class="btn btn-dark float-right">Confirm and Send</button>

                </form>

                <form method="POST"
                    action="{{ route('sms-broadcast-jobs.destroy', ['sms_broadcast_job' => $sms_broadcast_job->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </form>

            </div>
            <!--/col-sm-6-->

        </div>
        <!--/row-->

    </div>
    <!--/card-body-->

</div>

@endsection

@section('pageJs')
@endsection
