@section('contentTitle')
<h3>Edit SMS Bill</h3>
@endsection

@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form id="quickForm" method="POST" action="{{ route('sms_bills.update', ['sms_bill' => $sms_bill->id]) }}">
        @csrf
        @method('PUT')

        <div class="card-body">

            <!--sms_cost-->
            <div class="form-group">
                <label for="sms_cost"><span class="text-danger">*</span>SMS Cost</label>
                <input name="sms_cost" type="text" class="form-control @error('sms_cost') is-invalid @enderror"
                    id="sms_cost" value="{{ $sms_bill->sms_cost }}" required>
                @error('sms_cost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/sms_cost-->

        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')
@endsection
