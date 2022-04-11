@extends ('laraview.layouts.sideNavLayout')

@section('title')
Operators
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
$active_menu = '1';
$active_link = '1';
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')

<ul class="nav flex-column flex-sm-row ml-4">
    <!--New Operator-->
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('operators.create') }}">
            <i class="fas fa-plus"></i>
            New Operator
        </a>
    </li>
    <!--/New Operator-->
</ul>

@endsection

@section('content')

<div class="card">

    <!--modal -->
    <div class="modal" tabindex="-1" role="dialog" id="modal-default">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-auto" id="ModalBody">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /modal-content -->
        </div>
        <!-- /modal-dialog -->
    </div>
    <!-- /modal -->

    <div class="card-body">

        <table id="data_table" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Total User</th>
                    <th scope="col">Account Type</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operators as $operator)
                <tr>
                    <td scope="row">{{ $operator->id }}</td>
                    <td>{{ $operator->name }}</td>
                    <td>{{ $operator->company }}</td>
                    <td>{{ $operator->customers->count() }}</td>
                    <td>{{ $operator->account_type_alias }}</td>
                    @if ($operator->account_type == 'credit')
                    <td>{{ $operator->credit_balance }}</td>
                    @else
                    <td>{{ $operator->account_balance }}</td>
                    @endif
                    <td>{{ $operator->status }}</td>
                    <td>

                        <div class="btn-group" role="group">

                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>

                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                @if ($operator->deleting == 1)
                                {{-- deleting --}}
                                <a class="dropdown-item" href="#">
                                    Deleting...
                                </a>
                                {{-- deleting --}}
                                @else

                                {{-- Details --}}
                                @can('view', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.show',['operator' => $operator->id ]) }}">
                                    Details
                                </a>
                                @endcan
                                {{-- Details --}}

                                {{-- Edit --}}
                                @can('update', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.edit',['operator' => $operator->id]) }}">
                                    Edit
                                </a>
                                @endcan
                                {{-- Edit --}}

                                {{-- Edit Credit Limit --}}
                                @can('editLimit', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.credit-limit.create',['operator' => $operator->id]) }}">
                                    Edit Credit Limit
                                </a>
                                @endcan
                                {{-- Edit Credit Limit --}}

                                {{-- Add Balance --}}
                                @can('addBalance', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.account-balance.create',['operator' => $operator->id]) }}">
                                    Add Balance
                                </a>
                                @endcan
                                {{-- Add Balance --}}

                                {{-- Packages --}}
                                @can('assignPackages', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.master_packages.index', ['operator' => $operator->id]) }}">
                                    Packages
                                </a>
                                @endcan
                                {{-- Packages --}}

                                {{-- Billing Profiles --}}
                                @can('assignProfiles', $operator)
                                <a class="dropdown-item" href="#"
                                    onclick="showBillingProfiles('{{ route('operators.billing_profiles.index', ['operator' => $operator->id]) }}')">
                                    Billing Profiles
                                </a>
                                @endcan
                                {{-- Billing Profiles --}}

                                {{-- Special Permission --}}
                                @can('assignSpecialPermission', $operator)
                                <a class="dropdown-item" href="#"
                                    onclick="showSpecialPermissions('{{ route('operators.special-permission.index', ['operator' => $operator->id]) }}')">
                                    Special Permissions
                                </a>
                                @endcan
                                {{-- Special Permission --}}

                                {{-- Get Panel Access --}}
                                @can('getAccess', $operator)
                                <a class="dropdown-item" href="#" onclick="getPanelAccess({{ $operator->id }})">
                                    Get Panel Access
                                </a>
                                @endcan
                                {{-- Get Panel Access --}}

                                {{-- Suspend --}}
                                @can('suspend', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.suspend.create', ['operator' => $operator->id]) }}">
                                    Suspend
                                </a>
                                @endcan
                                {{-- Suspend --}}

                                {{-- Activate --}}
                                @can('activate', $operator)
                                <form method="post"
                                    action="{{ route('operators.activate.store', ['operator' => $operator->id]) }}"
                                    onsubmit="return showWait()">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Activate</button>
                                </form>
                                @endcan
                                {{-- Activate --}}

                                {{-- Delete --}}
                                @can('delete', $operator)
                                <a class="dropdown-item"
                                    href="{{ route('operators.destroy.create', ['operator' => $operator->id]) }}">
                                    Delete
                                </a>
                                @endcan
                                {{-- Delete --}}

                                @endif

                            </div>

                        </div>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <!--/card body-->

</div>

@endsection

@section('pageJs')

<script>
    function showBillingProfiles(url)
    {
        $.get( url, function( data ) {
            $("#modal-title").html("Billing Profiles");
            $("#ModalBody").html(data);
            $('#modal-default').modal('show');
            modalDataTable();
        });
    }

    function showSpecialPermissions(url)
    {
        $.get( url, function( data ) {
            $("#modal-title").html("Special Permissions");
            $("#ModalBody").html(data);
            $('#modal-default').modal('show');
        });
    }

    function getPanelAccess(operator)
    {
        $.get( "/admin/authenticate-operator-instance/" + operator, function( data ) {
            $("#modal-title").html("Get Panel Access");
            $("#ModalBody").html(data);
            $('#modal-default').modal('show');
        });
    }

</script>

@endsection
