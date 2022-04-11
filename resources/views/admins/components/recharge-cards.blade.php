@section('contentTitle')

<form method="GET" action="{{ route('recharge_cards.index') }}" autocomplete="off">
    <ul class="nav nav-fill flex-column flex-sm-row">
        <!--Generate Cards-->
        <li class="nav-item">
            <a class="btn btn-outline-success" href="{{ route('recharge_cards.create') }}">
                <i class="fas fa-plus"></i>
                Generate Cards
            </a>
        </li>
        <!--Generate Cards-->
        <!--Download Cards-->
        <li class="nav-item">
            <a class="btn btn-outline-success" href="{{ route('recharge_cards_download.create') }}">
                <i class="fas fa-download"></i>
                Download Cards
            </a>
        </li>
        <!--/Download Cards-->
        <!--distributor_id-->
        <li class="nav-item">
            <select name="distributor_id" class="custom-select mr-sm-2">
                <option selected value="">distributor...</option>
                @foreach ($distributors as $distributor)
                <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                @endforeach
            </select>
        </li>
        <!--/distributor_id-->
        <!--package_id-->
        <li class="nav-item ml-2">
            <select name="package_id" class="custom-select mr-sm-2">
                <option selected value="">package...</option>
                @foreach ($packages as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
                @endforeach
            </select>
        </li>
        <!--/package_id-->
        <!--status-->
        <li class="nav-item ml-2">
            <select name="status" class="custom-select mr-sm-2">
                <option selected value="">status...</option>
                <option value="used">used</option>
                <option value="unused">unused</option>
            </select>
        </li>
        <!--/status-->
        <!--pin-->
        <li class="nav-item ml-2">
            <input type="text" class="form-control" id="pin" name="pin" placeholder="PIN Number">
        </li>
        <!--/pin-->
        <!--creation_date-->
        <li class="nav-item ml-2">
            <input type='text' name='creation_date' id='creation_date' class='form-control' placeholder="Creation Date">
        </li>
        <!--/creation_date-->
        <li class="nav-item">
            <button type="submit" class="btn btn-primary">FILTER</button>
        </li>
    </ul>
</form>


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

        <table id="phpPaging" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Package</th>
                    <th scope="col">Status</th>
                    <th scope="col">PIN</th>
                    <th scope="col">Distributor</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Customer ID</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cards as $card)
                <tr @if ($card->status == 'used')
                    class="text-danger"
                    @endif>
                    <th scope="row">{{ $card->id }}</th>
                    <th>{{ $card->package->name }}</th>
                    <td>{{ $card->status }}</td>
                    <td>{{ $card->pin }}</td>
                    <td>{{ $card->distributor->name }}</td>
                    <td>{{ $card->creation_date }}</td>
                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $card->customer_id }}')">
                            @if ($card->customer_id)
                            <i class="fas fa-expand-alt"></i>
                            @endif
                            {{ $card->customer_id }}
                        </a>
                    </td>
                    <td class="d-sm-flex">
                        <form method="post"
                            action="{{ route('recharge_cards.destroy', ['recharge_card' => $card->id]) }}"
                            onsubmit="return confirm('Are you sure to Delete')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"><i
                                    class="fas fa-trash"></i>Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="card-footer">
        <div class="row">

            <div class="col-sm-2">
                Total Entries: {{ $cards->total() }}
            </div>

            <div class="col-sm-6">
                {{ $cards->withQueryString()->links() }}
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

    $(function () {
        $('#creation_date').datepicker({
            autoclose: !0
        });
    });

</script>
@endsection
