@section('contentTitle')

{{-- @Filter --}}
<form class="d-flex align-content-start flex-wrap" action="{{ route('online_customers.index') }}" method="get">


    {{-- sortby --}}
    <div class="form-group col-md-2">
        <select name="sortby" id="sortby" class="form-control">
            <option value=''>Sort By...</option>
            <option value="username">Username</option>
            <option value="bandwidth_usage">Bandwidth Usage</option>
        </select>
    </div>
    {{-- sortby --}}

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

    {{-- username --}}
    <div class="form-group col-md-2">
        <input type="text" name="username" id="username" class="form-control" placeholder="username LIKE ...">
    </div>
    {{-- username --}}

    <div class="form-group col-md-1">
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


    <!--traffic modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-traffic">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">
                        <span class="text-danger border border-danger">
                            LIVE
                        </span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="showOff()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="show_id" value="">

                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="font-weight-bold">Name: </span>
                            <span id="live_name"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Username: </span>
                            <span id="live_username"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Package Name: </span>
                            <span id="live_package"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Status: </span>
                            <span id="live_status"> </span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold text-success">Download (Kbps): </span>
                            <span id="live_download"></span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold text-primary">Upload (Kbps): </span>
                            <span id="live_upload"></span>
                        </li>
                    </ul>
                    <canvas id="smoothie-chart" width="470" height="200">
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        onclick="showOff()">Close</button>
                </div>

            </div>

        </div>

    </div>
    <!-- /traffic modal -->


    <div class="card-body">

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">MAC Addresses</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Download</th>
                    <th scope="col">Upload</th>
                    <th scope="col">UP Time</th>
                    <th scope="col">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($radaccts as $radacct )
                <tr>
                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $radacct->customer->id }}')">
                            {{ $radacct->username }}
                        </a>
                    </td>
                    <td>{{ $radacct->callingstationid }}</td>
                    <td>{{ $radacct->framedipaddress }}</td>
                    <td>{{ $radacct->acctoutputoctets/1000/1000/1000 }} GB</td>
                    <td>{{ $radacct->acctinputoctets/1000/1000/1000 }} GB</td>
                    <td>{{ sToHms($radacct->acctsessiontime) }}</td>
                    <td>{{ $radacct->acctupdatetime }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-2">
                Total Entries: {{ $radaccts->total() }}
            </div>
            <div class="col-sm-6">
                {{ $radaccts->withQueryString()->links() }}
            </div>
            <div class="col-sm-2 ml-2">
                {{-- <a class="btn btn-outline-danger" href="{{ route('delete-stale-sessions') }}">Delete Stales</a>
                --}}
            </div>
        </div>
    </div>
    <!--/card-footer-->

</div>

@endsection

@section('pageJs')

<script src="/jsPlugins/smoothie.js"></script>

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
