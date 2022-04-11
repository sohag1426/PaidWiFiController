@section('contentTitle')
<h4>Edit Suspend Date </h4>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form id="quickForm" method="POST"
            action="{{ route('customers.suspend_date.store', ['customer' => $customer->id]) }}"
            onsubmit="return showWait()">

            <div class="row">

                <div class="col-sm-6">

                    @csrf

                    <!--name-->
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer->name }}" disabled>
                    </div>
                    <!--/name-->

                    <!--username-->
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" class="form-control" id="name" value="{{ $customer->username }}" disabled>
                    </div>
                    <!--/username-->

                    <!--mobile-->
                    <div class="form-group">
                        <label for="mobile">Customer Mobile</label>
                        <input type="text" class="form-control" id="mobile" value="{{ $customer->mobile }}" disabled>
                    </div>
                    <!--/mobile-->

                    <!--package_expired_at-->
                    <div class='form-group'>
                        <label for='datepicker'><span class="text-danger">*</span>Suspend Date</label>
                        <input type='text' name='package_expired_at' id='datepicker' class='form-control'
                            value="{{ $customer->package_expired_at }}" required autocomplete="off">
                    </div>
                    <!--/package_expired_at-->

                    <button type="submit" class="btn btn-dark">SUBMIT</button>

                </div>
                <!--/col-sm-6-->

            </div>
            <!--/row-->

        </form>

    </div>

</div>

@endsection

@section('pageJs')
<script>
    $(function() {
        $('#datepicker').datepicker({
            autoclose: !0
        });
    });
</script>
@endsection
