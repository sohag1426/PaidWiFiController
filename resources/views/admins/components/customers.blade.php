@section('contentTitle')

{{-- @Filter --}}
<form class="d-flex align-content-start flex-wrap" action="{{ route('customers.index') }}" method="get">

    {{-- status --}}
    <div class="form-group col-md-2">
        <select name="status" id="status" class="form-control">
            <option value=''>status...</option>
            <option value='active'>active</option>
            <option value='suspended'>suspended</option>
            <option value='disabled'>disabled</option>
        </select>
    </div>
    {{--status --}}

    {{-- package_id --}}
    <div class="form-group col-md-2">
        <select name="package_id" id="package_id" class="form-control">
            <option value=''>package...</option>
            @foreach (Auth::user()->allPackages->groupBy('operator_id') as $gpackages)
            @foreach ($gpackages->sortBy('name') as $package)
            <option value="{{ $package->id }}">{{ $package->operator->name }} :: {{ $package->name }}</option>
            @endforeach
            @endforeach
        </select>
    </div>
    {{--package_id --}}

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

    {{-- sortby --}}
    <div class="form-group col-md-2">
        <select name="sortby" id="sortby" class="form-control">
            <option value=''>Sort By...</option>
            <option value="id">Customer ID</option>
            <option value="username">Username</option>
        </select>
    </div>
    {{-- sortby --}}

    {{-- username --}}
    <div class="form-group col-md-2">
        <input type="text" name="username" id="username" class="form-control" placeholder="username LIKE ...">
    </div>
    {{-- username --}}

    {{-- comment --}}
    <div class="form-group col-md-2">
        <input type="text" name="comment" id="comment" class="form-control" placeholder="comment LIKE ...">
    </div>
    {{-- comment --}}

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

    {{-- modal-delete --}}
    <div class="modal" id="modal-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Please Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="POST" id="delete-form">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal-delete --}}

    <!-- Modal Activate Options -->
    <div class="modal fade" id="ActivateOptionsModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="ActivateOptionsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ActivateOptionsModalCenterTitle">Activate Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ActivateOptionsModelContent">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Activate Options -->

    <div class="card-body">

        <table id="phpPaging" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mobile &amp; <br> Name</th>
                    <th scope="col">Username &amp; <br> Password</th>
                    <th scope="col">package &amp; <br> Validity</th>
                    <th scope="col">Payment Status &amp; <br> Status </th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($customers as $customer )
                <tr>

                    <td scope="row">{{ $customer->id }}</td>

                    <td>
                        <a href="#" onclick="showCustomerDetails('{{ $customer->id }}')">
                            {{ $customer->mobile }}
                        </a>
                        <br>
                        {{ $customer->name }}
                    </td>

                    <td>
                        {{ $customer->username }}
                        <br>
                        {{ $customer->password }}
                    </td>
                    <td>
                        {{ $customer->package_name }}
                        <br>
                        {{ $customer->package_expired_at }}
                        <br>
                        {{ $customer->remaining_validity }}
                    </td>
                    <td>
                        <span class="{{ $customer->payment_color }}"> {{ $customer->payment_status }} </span>
                        <br>
                        <span class="{{ $customer->color }}"> {{ $customer->status }} </span>

                    </td>
                    <td>
                        @include('admins.components.actions-on-customers')
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>


    <div class="card-footer">
        <div class="row">

            <div class="col-sm-2">
                Total Entries: {{ $customers->total() }}
            </div>

            <div class="col-sm-6">
                {{ $customers->links() }}
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
        $("#ModalBody").html('<div class="overlay"><i class="fas fa-sync-alt fa-spin"></i></div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Loading...</div>');
        $("#ModalBody").append('<div class="text-bold pt-2">Please Wait</div>');
        $('#modal-customer').modal('show');
        $.get( "/admin/customer-details/" + customer, function( data ) {
            $("#ModalBody").html(data);
        });
    }

    function deleteCustomer(url)
    {
        $("#delete-form" ).attr( "action", url );
        $('#modal-delete').modal('show');
    }

</script>
@endsection
