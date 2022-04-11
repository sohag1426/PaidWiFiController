@section('contentTitle')

{{-- @Filter --}}
<form class="d-flex align-content-start flex-wrap" action="{{ route('package_change_histories.index') }}" method="get"
    autocomplete="off">

    {{-- operator --}}
    @if (Auth::user()->role == 'group_admin')
    <div class="form-group col-md-2">
        <select name="operator_id" id="operator_id" class="form-control">
            <option value=''>operator...</option>
            @foreach (Auth::user()->operators->where('role', '!=', 'manager') as $operator)
            <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
            @endforeach
        </select>
    </div>
    @endif
    {{--operator --}}

    <!--from_date-->
    <div class='form-group col-md-2'>
        <input type='text' name='from_date' id='from_date' class='form-control' placeholder="From Date">
    </div>
    <!--/from_date-->

    <!--to_date-->
    <div class='form-group col-md-2'>
        <input type='text' name='to_date' id='to_date' class='form-control' placeholder="To Date">
    </div>
    <!--/to_date-->

    {{-- Page length --}}
    <div class="form-group col-md-2">
        <select name="length" id="length" class="form-control">
            <option value="{{ $length }}" selected>Show {{ $length }} entries </option>
            <option value="10">Show 10 entries</option>
            <option value="25">Show 25 entries</option>
            <option value="50">Show 50 entries</option>
            <option value="100">Show 100 entries</option>
        </select>
    </div>
    {{--Page length --}}

    <div class="form-group col-md-2">
        <button type="submit" class="btn btn-dark">FILTER</button>
    </div>

</form>
{{-- @endFilter --}}

@endsection

@section('content')

<div class="card">

    <!--modal -->
    <div class="modal fade" id="modal-customer">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ModalBody">

                    <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                    <div class="text-bold pt-2">Loading...</div>
                    <div class="text-bold pt-2">Please Wait</div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal -->

    <div class="card-body">

        <table id="phpPaging" class="table table-bordered">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>From Package</th>
                    <th>To Package</th>
                    <th>Changed By</th>
                    <th>Payment ID</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($change_histories as $change_history )

                <tr>
                    <td scope="row">{{ $change_history->id }}</td>
                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $change_history->customer_id }}')">
                            {{ $change_history->customer_id}} :: {{ $change_history->customer->mobile }}
                        </a>
                    </td>
                    <td>{{ $change_history->from_package }}</td>
                    <td>{{ $change_history->to_package }}</td>
                    <td>{{ $change_history->changed_by }} :: {{ $change_history->changer_id }}</td>
                    <td>{{ $change_history->customer_payment_id }}</td>
                    <td>{{ $change_history->status }}</td>
                    <td>{{ $change_history->created_at }}</td>
                </tr>

                @endforeach

            </tbody>

        </table>
    </div>

    <div class="card-footer">
        <div class="row">

            <div class="col-sm-2">
                Total Entries: {{ $change_histories->total() }}
            </div>

            <div class="col-sm-6">
                {{ $change_histories->withQueryString()->links() }}
            </div>

        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')

<script>
    $(function () {
        $('#from_date').datepicker({
            autoclose: !0
        });
    });

    $(function () {
        $('#to_date').datepicker({
            autoclose: !0
        });
    });

    function showCustomerDetails(customer)
    {
        $("#modal-title").html("Customer Details");
        $("#ModalBody").html('<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Loading...</div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Please Wait</div>');
        $('#modal-customer').modal('show');
        $.get( "/admin/customer-details/" + customer, function( data ) {
            $("#ModalBody").html(data);
        });
    }
</script>

@endsection
