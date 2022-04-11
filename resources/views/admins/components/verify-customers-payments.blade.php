@section('contentTitle')
<h3>Veify Payments</h3>
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
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Status</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">From Number</th>
                    <th scope="col">Gateway</th>
                    <th scope="col">Time</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($payments as $payment )
                <tr>
                    <th scope="row">{{ $payment->id }}</th>
                    <td>{{ $payment->username }}</td>
                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $payment->customer_id }}')">
                            {{ $payment->mobile }}
                        </a>
                    </td>
                    <td>{{ $payment->pay_status }}</td>
                    <td>{{ $payment->amount_paid }}</td>
                    <td>{{ $payment->card_number }}</td>
                    <td>{{ $payment->payment_gateway->send_money_provider }}</td>
                    <td>{{ $payment->created_at }}</td>

                    <td class="d-sm-flex">

                        {{-- Received --}}
                        <form method="post"
                            action="{{ route('verify-send-money.update', ['customer_payment' => $payment->id, 'action' => 'accept']) }}">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="far fa-check-circle"></i>
                                Received
                            </button>
                        </form>
                        {{-- Received --}}

                        {{-- Not Received --}}
                        <form method="post"
                            action="{{ route('verify-send-money.update', ['customer_payment' => $payment->id, 'action' => 'reject']) }}">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="far fa-times-circle"></i>
                                Not Received
                            </button>
                        </form>
                        {{-- Not Received --}}

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <!--/card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Entries: {{ $payments->total() }}
            </div>
            <div class="col-sm-6">
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')

<script>
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
