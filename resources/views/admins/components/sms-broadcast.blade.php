@section('contentTitle')
<h3>SMS Broadcast</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">

                <form method="POST" action="{{ route('sms-broadcast-jobs.store') }}">

                    @csrf

                    <!--connection_type-->
                    <div class="form-group">
                        <label for="connection_type"><span class="text-danger">*</span>Connection Type</label>
                        <select class="form-control" id="connection_type" name="connection_type" required>
                            <option value="">Please select...</option>
                            <option value='PPPoE'>PPP</option>
                            <option value='Hotspot'>Hotspot</option>
                            <option value='StaticIp'>StaticIp</option>
                        </select>
                    </div>
                    <!--/connection_type-->

                    <!--status-->
                    <div class="form-group">
                        <label for="status"><span class="text-danger">*</span>Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value='active' selected>active</option>
                            <option value='suspended'>suspended</option>
                            <option value='disabled'>disabled</option>
                        </select>
                    </div>
                    <!--/status-->

                    <!--payment_status-->
                    <div class="form-group">
                        <label for="payment_status">Payment Status (optional)</label>
                        <select class="form-control" id="payment_status" name="payment_status">
                            <option value="">Please select...</option>
                            <option value='billed'>billed</option>
                            <option value='paid'>paid</option>
                        </select>
                    </div>
                    <!--/payment_status-->

                    <!--zone_id-->
                    <div class="form-group">
                        <label for="zone_id">Customer Zone (optional)</label>
                        <select class="form-control" id="zone_id" name="zone_id">
                            <option value="">Please select...</option>
                            @foreach (Auth::user()->customer_zones->sortBy('name') as $customer_zone)
                            <option value="{{ $customer_zone->id }}">{{ $customer_zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/zone_id-->

                    <!--message-->
                    <div class="form-group">
                        <label for="message">Text Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <!--/message-->

                    <button type="submit" class="btn btn-dark">SUBMIT</button>

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
